<?php
namespace App\Http\Repositories\Struction;

use App\Constants\CommonConstant;
use App\Http\Repositories\BaseRepository;

class StructionDetailRepository extends BaseRepository {
    public function getModel()
    {
        return \App\Models\StructionDetails::class;
    }

    public function getByStructionPageId ($id, $params = [], $searchField = []) {
        $query = $this->model->where('structionPageId', $id)
                            ->join('struction_metas', function($join) {
                                $join->on('struction_details.id', '=', 'struction_metas.structionDetailId')
                                    ->whereNull('struction_metas.deleted_at');
                            });

            if (!empty($searchField)) {
                foreach ($searchField as $key => $value) {
                    if ($key === CommonConstant::STATUS) {
                        $query->where('status', $value);
                        continue;
                    }

                    $query->where('key', $key)
                        ->where('value', 'like', '%' . $value . '%');

                }
            }

        return $query->groupBy('struction_metas.structionDetailId')
                    ->orderBy('sequence', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->select('struction_details.*')
                    ->paginate(CommonConstant::PAGINATION_LIMIT)
                    ->appends($params);
    }

    public function getFirstByStructionPageId ($id) {
        return $this->model->where('structionPageId', $id)->first();
    }

    public function getByStructionPageIdForView ($id) {
        $query = $this->model->where('structionPageId', $id);
        return $query->orderBy('sequence', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get()->toArray();
    }
}
