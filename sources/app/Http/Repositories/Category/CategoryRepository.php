<?php
namespace App\Http\Repositories\Category;

use App\Constants\CommonConstant;
use App\Http\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function getPaginations ($postType) {
        return $this->model->where('postType', $postType)
                        ->orderBy('sequence', 'ASC')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(CommonConstant::PAGINATION_LIMIT)
                        ->appends(["posttype" => $postType]);
    }
}
