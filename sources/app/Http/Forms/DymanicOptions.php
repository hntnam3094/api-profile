<?php
namespace App\Http\Forms;

use App\Constants\PermissionConstant;
use Spatie\Permission\Models\Role;

class DymanicOptions {

    public static function roleOptions () {
        $roles = Role::where('name', '!=', PermissionConstant::SYSTEM_ADMIN)->get();
        $option[] = ['key' => '', 'value' => '- Select -'];

        if (!empty($roles)) {
            foreach ($roles as $role) {
                $option[] =  ['key' => $role->name, 'value' => $role->name];
            }
        }

        return $option;
    }
}
