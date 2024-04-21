<?php
namespace App\Http\Services;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
use App\Http\Forms\PostType\PostTypeForm;
use App\Http\Repositories\PostMapCategory\PostMapCategoryRepository;
use App\Http\Repositories\PostType\PostDetailRepository;
use App\Http\Repositories\PostType\PostMetaRepository;
use App\Http\Repositories\PostType\PostTypeRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostTypeService {
    private $postTypeRepository;
    private $postDetailRepository;
    private $postMetaRepository;
    private $postMapCategoryRepository;
    private $commonService;
    private $postTypeForm;

    public function __construct (
        PostTypeRepository $postTypeRepository,
        PostDetailRepository $postDetailRepository,
        PostMetaRepository $postMetaRepository,
        PostMapCategoryRepository $postMapCategoryRepository,
        CommonService $commonService,
        PostTypeForm $postTypeForm)
    {
        $this->postTypeRepository = $postTypeRepository;
        $this->postDetailRepository = $postDetailRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->postMapCategoryRepository = $postMapCategoryRepository;
        $this->commonService = $commonService;
        $this->postTypeForm = $postTypeForm;
    }

    public function getPaginationByPostType ($postType, $params) {
        if (!empty($postType)) {
            $form = $this->postTypeForm->getForm($postType);
            $listField = $this->getKeyOfFieldList($postType);
            $searchFields = [];
            if (!empty($form[PostTypeConstant::fieldSearch])) {
                foreach ($form['search'] as $search) {
                    $searchFields[$search['name']] = $params[$search['name']] ?? $search['value'];
                }
            }

            $listPostDetail = $this->postTypeRepository->getPaginationByPostType($postType, $params, $searchFields);

            if (count($listPostDetail) > 0) {
                foreach ($listPostDetail as &$postDetail) {
                    $postDetail = $this->setPostMetaForDetail($postType, $postDetail, $postDetail->id, $listField);
                }
            }

            return [$listPostDetail, $form, $searchFields];
        }
        return [];
    }

    public function getDataFormById ($id) {
        if ($id) {
            $postDetail = $this->postDetailRepository->find($id);
            if (!empty($postDetail)) {
                $postType = $this->postTypeRepository->find($postDetail->postTypeId)->code ?? '';
                $postDetailId = $postDetail->id ?? 0;
                $form = $this->postTypeForm->getForm($postType);
                $dataForm = [];

                if (!empty($postDetailId)) {
                    $dataForm = $this->getKeyValueByMeta($postDetail->postMeta, $postType, $postDetail);
                }

                return [$dataForm, $form, $postType];
            }
        }
        return [];
    }

    private function getKeyValueByMeta ($metaData, $postType,  $postDetail = null) {
        $data = [];
        foreach ($metaData as $key => $item) {
            $type = $this->getKeyFormByInputKey($item->metaKey, $postType);
            $value = $item->metaValue;

            if ($type === CommonConstant::IMAGE) {
                $value = Storage::url($item->metaValue);
            }

            if ($type === CommonConstant::IMAGES) {
                $value = json_decode($value);

                foreach($value as &$val) {
                    if (!empty($val->image)) {
                        $val->image = Storage::url($val->image);
                    }
                }

            }

            $data[$item->metaKey] = $value ?? '';
        }

        if (!empty($postDetail)) {
            $data['status'] = $postDetail->status;
            $data['sequence'] = $postDetail->sequence;
        }

        return $data;
    }

    public function deletePostDetailById ($id) {
        if ($id) {
            $postDetail = $this->postDetailRepository->find($id);
            $postType = $this->postTypeRepository->find($postDetail->postTypeId)->code ?? '';

            $this->postDetailRepository->delele($id);

            return $postType;
        }

        return false;
    }

    public function save ($attr, $id = 0) {
        $structionPageField = ['status', 'sequence'];

        try {
            DB::beginTransaction();

            list($attr, $postType) = $this->getAttributeAndPostType($attr);

            if (!empty($id)) {
                $this->postMetaRepository->deleteByPostDetailId($id);
            } else {
                $postTypeId = $this->postTypeRepository->getFieldByCode($postType, 'id');

                $id = $this->postDetailRepository->create([
                    'postTypeId' => $postTypeId
                ])->id;
            }

            if (!empty($id) && !empty($attr)) {
                foreach ($attr as $key => $value) {
                    $type = $this->getKeyFormByInputKey($key, $postType);

                    if(in_array($key, $structionPageField)) {
                        $this->postDetailRepository->update($id, [$key => $value]);
                        continue;
                    }

                    if ($type === CommonConstant::IMAGE) {
                        $value = $this->commonService->saveImages($value);
                    }

                    if ($type === CommonConstant::IMAGES) {
                        foreach ($value as &$val) {
                            $val['image'] = $this->commonService->saveImages($val['image'] ?? '');
                        }

                        $value = json_encode($value);
                    }

                    if ($key === PostTypeConstant::fieldCategory) {

                        $this->postMapCategoryRepository->create([
                            'postId' => $id,
                            'categoryId' => $value
                        ]);
                    }

                    $this->postMetaRepository->create([
                        'postDetailId' => $id,
                        'metaKey' => $key,
                        'metaValue' => $value ?? ''
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    private function getAttributeAndPostType ($attr) {
        $postType = $attr['posttype'];
        unset($attr['posttype']);

        return [$attr, $postType];
    }

    private function getKeyOfFieldList ($postType) {
        $newArr = [];
        if ($postType) {
            $arr = $this->postTypeForm->getForm($postType, false, PostTypeConstant::fieldList);
            if (count($arr) > 0) {
                foreach($arr as $item) {
                    $newArr[] = $item['key'];
                }
            }
        }

        return $newArr;
    }

    private function getKeyFormByInputKey ($key, $postType) {
        $form = $this->postTypeForm->getForm($postType, false, PostTypeConstant::fieldForm);
        foreach ($form as $item) {
            if ($item['name'] == $key) {
                return $item['type'];
            }
        }

        return $key;
    }

    public function getDataByPostType ($postType) {
        if (!empty($postType)) {
            $listPostDetail = $this->postTypeRepository->getByPostType($postType);

            if (count($listPostDetail) > 0) {
                foreach ($listPostDetail as &$postDetail) {
                    $postDetail = $this->setPostMetaForDetail($postType, $postDetail, $postDetail['id']);
                }
            }

            return $listPostDetail;
        }
        return [];
    }

    public function getPosttypeDataByCategoryId ($postType, $categoryId) {
        if (!empty($postType)) {
            $listPostDetail = $this->postTypeRepository->getByPostType($postType, $categoryId);

            if (count($listPostDetail) > 0) {
                foreach ($listPostDetail as &$postDetail) {
                    $postDetail = $this->setPostMetaForDetail($postType, $postDetail, $postDetail['id']);
                }
            }

            return $listPostDetail;
        }
        return [];
    }

    public function getDataByCategorySlug ($postType, $categorySlug) {
        if (!empty($postType)) {
            $listPostDetail = $this->postTypeRepository->getByPostTypeAndCategorySlug($postType, $categorySlug);

            if (count($listPostDetail) > 0) {
                foreach ($listPostDetail as &$postDetail) {
                    $postDetail = $this->setPostMetaForDetail($postType, $postDetail, $postDetail['id']);
                }
            }

            return $listPostDetail;
        }
        return [];
    }

    public function getBySlug ($postType, $slug) {
        if (!empty($slug)) {
            $data = $this->postTypeRepository->getBySlug($postType, $slug);

            if (empty($data)) {
                return [];
            }

            $data = $this->setPostMetaForDetail($postType, $data, $data['id']);

            return $data;
        }

        return [];
    }

    private function setPostMetaForDetail ($postType, $data, $id, $listField = []) {
        $postMeta = $this->postMetaRepository->getByPostDetailId($id, $listField);
        if (!empty($postMeta)) {
            foreach ($postMeta as $meta) {
                $type = $this->getKeyFormByInputKey($meta['metaKey'], $postType);
                if ($type == CommonConstant::IMAGE) {
                    $meta['metaValue'] = Storage::url($meta['metaValue']);
                }
                $data[$meta['metaKey']] = $meta['metaValue'];
            }
        }

        return $data;
    }
}
