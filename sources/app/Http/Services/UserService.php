<?php
namespace App\Http\Services;

use App\Http\Forms\DymanicForm\UserForm;
use App\Http\Repositories\UserRepository;

class UserService {

    private $userRepository;
    private $userForm;

    public function __construct(UserRepository $userRepository, UserForm $userForm)
    {
        $this->userRepository = $userRepository;
        $this->userForm = $userForm;
    }

    public function getData ($params = []) {
        return $this->userRepository->getPaginations($params);
    }

    public function showData ($id) {
        $user = $this->userRepository->find($id);
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames(),
            'status' => $user->status
        ];

        return [$data, $this->userForm->getForm()];
    }

    public function updateUser ($id, $params) {
        $this->userRepository->update($id, $params);
        $user = $this->userRepository->find($id);

        if ($user) {
            $user->syncRoles($params['role']);
        }
    }

    public function getForm () {
        return $this->userForm->getForm();
    }
}
