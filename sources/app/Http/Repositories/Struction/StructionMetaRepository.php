<?php
namespace App\Http\Repositories\Struction;

use App\Http\Repositories\BaseRepository;

class StructionMetaRepository extends BaseRepository {
    public function getModel()
    {
        return \App\Models\StructionMetas::class;
    }

    public function getByStructionDetailId ($id) {
        return $this->model->where('structionDetailId', $id)
            ->get();
    }

    public function deleteByStructionDetailId ($id) {
        return $this->model->where('structionDetailId', $id)->delete();
    }

    public function getByIdAndField ($id, $field = []) {
        $query = $this->model->where('structionDetailId', $id);
        if (!empty($field)) {
            $query->where('key', $field);
        }
        return $query->select('key', 'value')->first();
    }
}
