<?php
namespace App\Http\Services;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
use App\Http\Forms\PostType\PostTypeForm;
use App\Http\Repositories\Category\CategoryMetaRepository;
use App\Http\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryService {
    private $categoryRepository;
    private $categoryMetaReposioty;
    private $commonService;
    private $postTypeForm;
    private $postTypeService;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryMetaRepository $categoryMetaReposioty,
        CommonService $commonService,
        PostTypeForm $postTypeForm,
        PostTypeService $postTypeService
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryMetaReposioty = $categoryMetaReposioty;
        $this->commonService = $commonService;
        $this->postTypeForm = $postTypeForm;
        $this->postTypeService = $postTypeService;
    }

    public function getPaginationsByPostType ($postType) {
        if ($postType) {
            $listCategory = $this->categoryRepository->getPaginations($postType);

            $listField = $this->getKeyOfFieldList($postType);

            if (count($listCategory) > 0) {
                foreach ($listCategory as &$categoryDetail) {
                    $postMeta = $this->categoryMetaReposioty->getByCategoryId($categoryDetail->id, $listField);
                    if (!empty($postMeta)) {
                        foreach ($postMeta as $meta) {
                            $type = $this->getKeyFormByInputKey($meta->metaKey, $postType);
                            if ($type == CommonConstant::IMAGE) {
                                $meta->metaValue = Storage::url($meta->metaValue);
                            }
                            $categoryDetail[$meta->metaKey] = $meta->metaValue;
                        }
                    }
                }
            }

            return $listCategory;
        }

        return [];
    }

    public function getDataFormById ($id) {
        if ($id) {
            $category = $this->categoryRepository->find($id);

            if (!empty($category)) {
                $postType = $category->postType;
                $form = $this->postTypeForm->getForm($postType, $id);
                $dataForm = [];

                $dataForm = $this->getKeyValueByMeta($category->categoryMeta, $postType, $category);

                return [$dataForm, $form, $postType];
            }
        }
        return [];
    }

    public function deleteCategoryById ($id) {
        if ($id) {
            $categoryRecord = $this->categoryRepository->find($id);
            $postType = $categoryRecord->postType;

            $this->categoryRepository->delele($id);

            return $postType;
        }
        return '';
    }

    public function save ($attr, $id = 0) {
        $structionPageField = ['status', 'sequence', 'parentId'];

        try {
            DB::beginTransaction();

            list($attr, $postType) = $this->getAttributeAndPostType($attr);

            if (!empty($id)) {
                $this->categoryMetaReposioty->deleteByCategoryId($id);
            } else {
                $id = $this->categoryRepository->create([
                    'postType' => $postType
                ])->id;
            }

            if (!empty($id) && !empty($attr)) {
                foreach ($attr as $key => $value) {
                    $type = $this->getKeyFormByInputKey($key, $postType);

                    if(in_array($key, $structionPageField)) {
                        if (($key == 'parentId' && (empty($value) || $value == $id))) {
                            $value = 0;
                        }

                        $this->categoryRepository->update($id, [$key => $value]);
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

                    $this->categoryMetaReposioty->create([
                        'categoryId' => $id,
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
            $arr = $this->postTypeForm->getForm($postType, false, PostTypeConstant::fieldCategoryList);
            if (count($arr) > 0) {
                foreach($arr as $item) {
                    $newArr[] = $item['key'];
                }
            }
        }

        return $newArr;
    }

    private function getKeyValueByMeta ($metaData, $postType, $postDetail = null) {
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
            $data['parentId'] = !empty($postDetail->parentId) ? $postDetail->parentId : '';
        }

        return $data;
    }

    private function getKeyFormByInputKey ($key, $postType) {
        $form = $this->postTypeForm->getForm($postType, false, PostTypeConstant::fieldCategory);
        foreach ($form as $item) {
            if ($item['name'] == $key) {
                return $item['type'];
            }
        }

        return $key;
    }

    public function getCategoryData($postType) {
        if ($postType) {
            $listCategory = $this->categoryRepository->getByPostType($postType);
            if (count($listCategory) > 0) {
                foreach ($listCategory as &$categoryDetail) {
                    $postMeta = $this->categoryMetaReposioty->getByCategoryId($categoryDetail['id']);
                    if (!empty($postMeta)) {
                        foreach ($postMeta as $meta) {
                            $type = $this->getKeyFormByInputKey($meta['metaKey'], $postType);
                            if ($type == CommonConstant::IMAGE) {
                                $meta['metaValue'] = Storage::url($meta['metaValue']);
                            }
                            $categoryDetail[$meta['metaKey']] = $meta['metaValue'];
                        }
                    }
                }
            }

            return $listCategory;
        }

        return [];
    }

    public function getCategoryAndPostTypeData($postType) {
        if ($postType) {
            $listCategory = $this->categoryRepository->getByPostType($postType);
            if (count($listCategory) > 0) {
                foreach ($listCategory as &$categoryDetail) {
                    $postMeta = $this->categoryMetaReposioty->getByCategoryId($categoryDetail['id']);
                    if (!empty($postMeta)) {
                        foreach ($postMeta as $meta) {
                            $type = $this->getKeyFormByInputKey($meta['metaKey'], $postType);
                            if ($type == CommonConstant::IMAGE) {
                                $meta['metaValue'] = Storage::url($meta['metaValue']);
                            }
                            $categoryDetail[$meta['metaKey']] = $meta['metaValue'];
                        }
                    }

                    $categoryDetail['data'] = $this->postTypeService->getPosttypeDataByCategoryId($postType, $categoryDetail['id']);
                }
            }

            return $listCategory;
        }

        return [];
    }
}
