<?php
namespace App\Http\Repositories\Struction;

use App\Constants\CommonConstant;
use App\Http\Repositories\BaseRepository;

class StructionDetailRepository extends BaseRepository {
    public function getModel()
    {
        return \App\Models\StructionDetails::class;
    }

    public function getByStructionPageId ($id) {
        return $this->model->where('structionPageId', $id)
            ->orderBy('sequence', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->paginate(CommonConstant::PAGINATION_LIMIT);
    }
}
