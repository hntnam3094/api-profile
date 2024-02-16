<?php
namespace App\Http\Repositories;

interface RepositoryInterface {
    public function getAll ();
    public function find ($id);
    public function create ($params = []);
    public function update ($id, $params = []);
    public function delele ($id);
}
