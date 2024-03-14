<?php
namespace App\Http\Repositories;

use App\Constants\CommonConstant;
use App\Http\Repositories\BaseRepository;

class UserRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getPaginations ($params) {
        $query = $this->model->query();

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . ($params['name']) . '%');
        }

        return $query->where('name', 'like', '%' . ($params['name'] ?? '') . '%')
                    ->orderBy('created_at', 'DESC')
                    ->select('id', 'name', 'status', 'created_at')
                    ->paginate(CommonConstant::PAGINATION_LIMIT)
                    ->appends($params);
    }
}
