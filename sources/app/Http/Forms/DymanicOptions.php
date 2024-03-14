<?php
namespace App\Http\Forms;

use Spatie\Permission\Models\Role;

class DymanicOptions {

    public static function roleOptions () {
        $option[] = ['key' => '', 'value' => '- Select -'];
        foreach (Role::all() as $role) {
            $option[] =  ['key' => $role->name, 'value' => $role->name];
        }

        return $option;
    }
}
