<?php
namespace App\Http\Repositories\PostMapCategory;

use App\Http\Repositories\BaseRepository;

class PostMapCategoryRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\PostMapCategory::class;
    }
}
