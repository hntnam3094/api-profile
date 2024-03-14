<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();

        $role = Role::create(
            [
                'name' => 'admin'
            ]
        );

        $permissions = [
            ['name' => 'view developer'],
            ['name' => 'view struction'],
            ['name' => 'edit struction'],
            ['name' => 'view posttype'],
            ['name' => 'edit posttype']
        ];

        foreach ($permissions as $permissionData) {
            $permission = Permission::create($permissionData);
            $permission->assignRole($role);
        }
    }
}
