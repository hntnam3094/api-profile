<?php
namespace App\Http\Services;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
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

    public function __construct(PostTypeRepository $postTypeRepository, PostDetailRepository $postDetailRepository, PostMetaRepository $postMetaRepository)
    {
        $this->postTypeRepository = $postTypeRepository;
        $this->postDetailRepository = $postDetailRepository;
        $this->postMetaRepository = $postMetaRepository;
    }

    public function getPaginationByPostType ($postType) {
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

    public function getDataFormById ($id) {
        $postDetail = $this->postDetailRepository->find($id);
        $postType = $this->postTypeRepository->find($postDetail->postTypeId)->code ?? '';
        $postDetailId = $postDetail->id ?? 0;
        $form = PostTypeConstant::getForm($postType);
        $dataForm = [];
        if (!empty($postDetailId)) {
            $postMeta = $this->postMetaRepository->getByPostDetailId($postDetail->id);
            $dataForm = $this->getKeyValueByMeta($postMeta, $postDetail);
        }

        return [$dataForm, $form, $postType];
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
                        $value = $this->saveImages($value);
                    }

                    if ($key === CommonConstant::IMAGES) {
                        foreach ($value as &$val) {
                            $val['image'] = $this->saveImages($val['image']);
                        }

                        $value = json_encode($value);
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

    private function saveImages ($value) {
        $path = '';
        if ($value && $value[0] && gettype($value[0]) != 'string') {
            $image = $value[0];
            $imgName = time() . time().rand(100,999) . '.' . $image->getClientOriginalExtension();
            $path = 'struction/' . Carbon::now()->format('Ymd') . '/' . $imgName;
            Storage::disk(config('disks.public'))->put('public/' . $path, file_get_contents($image));
        }
        return $path;
    }

    private function getAttributeAndPostType ($attr) {
        $postType = $attr['posttype'];
        unset($attr['posttype']);

        return [$attr, $postType];
    }

    private function getKeyOfFieldList ($postType) {
        $arr = PostTypeConstant::getForm($postType, false, PostTypeConstant::fieldList);
        $newArr = [];
        if (count($arr) > 0) {
            foreach($arr as $item) {
                $newArr[] = $item['key'];
            }
        }

        return $newArr;
    }

}
