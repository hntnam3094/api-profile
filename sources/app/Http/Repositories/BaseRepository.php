<?php

namespace App\Http\Repositories;

use App\Http\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct ()
    {
        $this->setModel();
    }

    public function setModel ()
    {
        $this->model = app()->make($this->getModel());
    }

    abstract public function getModel ();

    public function getAll ()
    {
        return $this->model->all();
    }

    public function find ($id)
    {
        return $this->model->find($id);
    }

    public function create ($params = [])
    {
        return $this->model->create($params);
    }

    public function update ($id, $params = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($params);
            return $result;
        }
        return false;
    }

    public function delele ($id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }
}
