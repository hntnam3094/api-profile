<?php
namespace App\Http\Repositories\PostType;

use App\Http\Repositories\BaseRepository;

class PostMetaRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\PostMeta::class;
    }

    public function deleteByPostDetailId ($id) {
        return $this->model->where('postDetailId', $id)->delete();
    }

    public function getByPostDetailId ($id, $key = []) {
        $query = $this->model->where('postDetailId', $id);
        if (!empty($key)) {
            $query->whereIn('metaKey', $key);
        }
        return $query->select('metaKey', 'metaValue')->get()->toArray();
    }
}
