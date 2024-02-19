<?php
namespace App\Http\Repositories\PostType;

use App\Constants\CommonConstant;
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

    public function getPaginationByPostType ($postType) {
        $record = $this->model
                        ->join('post_detail', function($join) {
                            $join->on('post_type.id', '=', 'post_detail.postTypeId')
                                ->whereNull('post_detail.deleted_at');
                        })
                        ->where('post_type.code', $postType)
                        ->orderBy('post_detail.sequence', 'ASC')
                        ->orderBy('post_detail.created_at', 'DESC')
                        ->select('post_detail.*')
                        ->paginate(CommonConstant::PAGINATION_LIMIT);

        return $record;
    }

}
