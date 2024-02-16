<?php
namespace App\Http\Repositories\Struction;

use App\Http\Repositories\BaseRepository;
use App\Constants\CommonConstant;
class StructionPageRepository extends BaseRepository {
    public function getModel()
    {
        return \App\Models\StructionPages::class;
    }

    public function getPaginations () {
        return $this->model->paginate(CommonConstant::PAGINATION_LIMIT);
    }

    public function getByPageCodeAndCode ($pageCode, $code) {
        $data = $this->model->where('pageCode', $pageCode)->where('code', $code)->select('id')->first();

        return $data->id;
    }
}
