<?php
namespace App\Http\Repositories\PostType;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
use App\Http\Repositories\BaseRepository;

class PostTypeRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\PostType::class;
    }

    public function getFieldByCode ($code, $field) {
        $record = $this->model->where('code', $code)->first();
        return $record->$field;
    }

    public function getPaginationByPostType ($postType, $params = [], $searchFields = []) {
        $query = $this->model
                        ->join('post_detail', function($join) {
                            $join->on('post_type.id', '=', 'post_detail.postTypeId')
                                ->whereNull('post_detail.deleted_at');
                        })
                        ->join('post_meta', function($join) {
                            $join->on('post_detail.id', '=', 'post_meta.postDetailId')
                                ->whereNull('post_meta.deleted_at');
                        })
                        ->leftJoin('post_map_category', function($join) {
                            $join->on('post_detail.id', '=', 'post_map_category.postId')
                                ->whereNull('post_map_category.deleted_at');
                        })
                        ->where('post_type.code', $postType);

        if (!empty($searchFields)) {
            foreach ($searchFields as $key => $value) {
                if ($key === CommonConstant::STATUS) {
                    $query->where('status', $value);
                    continue;
                }

                if ($key === PostTypeConstant::fieldCategory) {
                    if (empty($value)) {
                        continue;
                    }
                    $query->where('categoryId', $value);
                    continue;
                }

                $query->where('metaKey', $key)
                    ->where('metaValue', 'like', '%' . $value . '%');

            }
        }

        return $query->groupBy('post_meta.postDetailId')
                    ->orderBy('post_detail.sequence', 'ASC')
                    ->orderBy('post_detail.created_at', 'DESC')
                    ->select('post_detail.*')
                    ->paginate(CommonConstant::PAGINATION_LIMIT)
                    ->appends($params);
    }

}
