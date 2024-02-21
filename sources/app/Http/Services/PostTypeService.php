<?php
namespace App\Http\Services;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
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

    public function __construct (
        PostTypeRepository $postTypeRepository,
        PostDetailRepository $postDetailRepository,
        PostMetaRepository $postMetaRepository,
        PostMapCategoryRepository $postMapCategoryRepository,
        CommonService $commonService)
    {
        $this->postTypeRepository = $postTypeRepository;
        $this->postDetailRepository = $postDetailRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->postMapCategoryRepository = $postMapCategoryRepository;
        $this->commonService = $commonService;
    }

    public function getPaginationByPostType ($postType) {
        if (!empty($postType)) {
            $listPostDetail = $this->postTypeRepository->getPaginationByPostType($postType);
            $listField = $this->getKeyOfFieldList($postType);

            if (count($listPostDetail) > 0) {
                foreach ($listPostDetail as &$postDetail) {
                    $postMeta = $this->postMetaRepository->getByPostDetailId($postDetail->id, $listField);
                    if (!empty($postMeta)) {
                        foreach ($postMeta as $meta) {
                            if ($meta->metaKey == CommonConstant::IMAGE) {
                                $meta->metaValue = Storage::url($meta->metaValue);
                            }
                            $postDetail[$meta->metaKey] = $meta->metaValue;
                        }
                    }
                }
            }

            return $listPostDetail;
        }
        return [];
    }

    public function getDataFormById ($id) {
        if ($id) {
            $postDetail = $this->postDetailRepository->find($id);
            if (!empty($postDetail)) {
                $postType = $this->postTypeRepository->find($postDetail->postTypeId)->code ?? '';
                $postDetailId = $postDetail->id ?? 0;
                $form = PostTypeConstant::getForm($postType);
                $dataForm = [];

                if (!empty($postDetailId)) {
                    $dataForm = $this->getKeyValueByMeta($postDetail->postMeta, $postDetail);
                }

                return [$dataForm, $form, $postType];
            }
        }
        return [];
    }

    private function getKeyValueByMeta ($metaData, $postDetail = null) {
        $data = [];
        foreach ($metaData as $key => $item) {
            $value = $item->metaValue;

            if ($item->metaKey === CommonConstant::IMAGE) {
                $value = Storage::url($item->metaValue);
            }

            if ($item->metaKey === CommonConstant::IMAGES) {
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

                    if(in_array($key, $structionPageField)) {
                        $this->postDetailRepository->update($id, [$key => $value]);
                        continue;
                    }

                    if ($key === CommonConstant::IMAGE) {
                        $value = $this->commonService->saveImages($value);
                    }

                    if ($key === CommonConstant::IMAGES) {
                        foreach ($value as &$val) {
                            $val['image'] = $this->commonService->saveImages($val['image']);
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
            $arr = PostTypeConstant::getForm($postType, false, PostTypeConstant::fieldList);
            if (count($arr) > 0) {
                foreach($arr as $item) {
                    $newArr[] = $item['key'];
                }
            }
        }

        return $newArr;
    }

}
