<?php
namespace App\Http\Services;

use App\Constants\PermissionConstant;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService {

    public function getAllRoles () {
        return Role::where('name', '!=', PermissionConstant::SYSTEM_ADMIN)->get();
    }

    public function getPermissionByRoleId ($id) {
        $role = Role::findById($id);
        return $role;
    }

    public function getDefaultPermisson ($id = 0) {
        $permissions = [];
        $permissionByRole = [];

        if (!empty($id)) {
            $role = Role::findById($id);
            $permissionByRole = $role->getAllPermissions();
        }

        foreach (PermissionConstant::PERMISSION as $key => $permission) {
            $permissionName = $permission['name'];
            $permissions[$key]['name'] = $permissionName;
            foreach ($permission['action'] as $key2 => $action) {
                $permissionAction = $action . ' ' . $permissionName;
                $permissions[$key]['action'][$key2]['name'] = $permissionAction;
                $permissions[$key]['action'][$key2]['hasPermission'] = $this->findPermissionInRoles($permissionByRole, $permissionAction);
            }
        }

        return $permissions;
    }

    public function updatePermissionByRole ($id, $params) {
        if (!empty($id)) {
            $role = Role::findById($id);

            $syncPermission = [];
            if (!empty($params)) {
                foreach ($params['permission'] as $permission) {
                    if (empty($permission['action'])) {
                        continue;
                    }

                    foreach ($permission['action'] as $action) {
                        if(empty($action['hasPermission'])) {
                            continue;
                        }

                        $syncPermission[] = $action['name'];
                    }
                }
            }

            $role->syncPermissions($syncPermission);
        }
    }

    private function findPermissionInRoles ($permissionByRole, $permissionAction) {
        foreach ($permissionByRole as $permission) {
            if ($permission['name'] == $permissionAction) {
                return true;
            }
        }

        return false;
    }
}
