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
}
