<?php
namespace App\Http\Repositories\Category;

use App\Http\Repositories\BaseRepository;

class CategoryMetaRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\CategoryMeta::class;
    }

    public function deleteByCategoryId ($id) {
        return $this->model->where('categoryId', $id)->delete();
    }

    public function getByCategoryId ($id, $key = []) {
        $query = $this->model->where('categoryId', $id);
        if (!empty($key)) {
            $query->whereIn('metaKey', $key);
        }
        return $query->select('metaKey', 'metaValue')->get();
    }
}
