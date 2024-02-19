<?php
namespace App\Http\Repositories\PostType;

use App\Http\Repositories\BaseRepository;

class PostDetailRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\PostDetail::class;
    }

    public function createAndGetId ($attr) {
        $modelRecord = $this->model->create($attr);

        return $modelRecord->id;
    }
}
