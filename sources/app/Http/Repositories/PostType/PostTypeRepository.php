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

    public function getByPostType ($postType, $categoryId = null) {
        $query = $this->model->join('post_detail', function($join) {
                            $join->on('post_type.id', '=', 'post_detail.postTypeId')
                                ->whereNull('post_detail.deleted_at');
                        })
                        ->where('post_type.code', $postType)
                        ->where('post_detail.status', CommonConstant::STATUS_ACTIVE);

        if (!is_null($categoryId)) {
            $query->join('post_map_category', function ($join) {
                $join->on('post_detail.id', '=', 'post_map_category.postId')
                    ->whereNull('post_map_category.deleted_at');
            })
            ->where('post_map_category.categoryId', $categoryId);
        }

        return $query->orderBy('post_detail.sequence', 'ASC')
                    ->orderBy('post_detail.created_at', 'DESC')
                    ->select('post_detail.*')
                    ->get()->toArray();
    }


    public function getBySlug ($postType, $slug) {
        $query = $this->model
                ->join('post_detail', function($join) {
                    $join->on('post_type.id', '=', 'post_detail.postTypeId')
                        ->whereNull('post_detail.deleted_at');
                })
                ->join('post_meta', function($join) {
                    $join->on('post_detail.id', '=', 'post_meta.postDetailId')
                        ->whereNull('post_meta.deleted_at');
                })
                ->where('post_type.code', $postType)
                ->where('metaKey', 'slug')
                ->where('metaValue', 'like', '%' . $slug . '%');


        return $query->groupBy('post_meta.postDetailId')
            ->orderBy('post_detail.sequence', 'ASC')
            ->orderBy('post_detail.created_at', 'DESC')
            ->select('post_detail.*')
            ->first()->toArray();
    }


    public function getByPostTypeAndCategorySlug ($postType, $categorySlug) {
        $query = $this->model->join('post_detail', function($join) {
            $join->on('post_type.id', '=', 'post_detail.postTypeId')
                ->whereNull('post_detail.deleted_at');
        })
        ->where('post_type.code', $postType)
        ->where('post_detail.status', CommonConstant::STATUS_ACTIVE)
        ->join('post_map_category', function ($join) {
            $join->on('post_detail.id', '=', 'post_map_category.postId')
                ->whereNull('post_map_category.deleted_at');
            })
        ->join('category', function ($join) {
            $join->on('post_map_category.categoryId', '=', 'category.id')
                ->whereNull('category.deleted_at');
        })
        ->join('category_meta', function ($join) {
            $join->on('category.id', 'category_meta.categoryId')
                ->whereNull('category_meta.deleted_at');
        })
        ->where('category_meta.metaKey', 'slug')
        ->where('category_meta.metaValue', $categorySlug);

        return $query->orderBy('post_detail.sequence', 'ASC')
                    ->orderBy('post_detail.created_at', 'DESC')
                    ->select('post_detail.*')
                    ->get()->toArray();
    }

}
