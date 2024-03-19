<?php

namespace Database\Seeders;

use App\Constants\PermissionConstant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();

        foreach(PermissionConstant::ROLE as $role) {
            Role::create($role);
        }

        $permissions = [];

        foreach (PermissionConstant::PERMISSION as $permission) {
            $permissionName = $permission['name'];
            foreach ($permission['action'] as $action) {
                $permissionAction = $action . ' ' . $permissionName;
                $permissions[]['name'] = $permissionAction;
            }
        }

        foreach ($permissions as $permissionData) {
            $permission = Permission::create($permissionData);
            foreach (Role::all() as $role) {
                $permission->assignRole($role);
            }
        }

        $user = User::where('email', 'admin@gmail.com')->first();

        if (empty($user)) {
            $user = new User();
            $user->name = 'System Admin';
            $user->password = Hash::make('test1234');
            $user->email = 'admin@gmail.com';
            $user->status = 1;
            $user->save();
        }

        $user->syncRoles([PermissionConstant::SYSTEM_ADMIN]);
    }
}
