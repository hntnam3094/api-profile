<?php

namespace App\Http\Middleware;

use App\Constants\PostTypeConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        list($roles, $permissions) = $this->getRoleAndPermission($user);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'posttype' => DB::table('post_type')->get(),
                'roles' => $roles,
                'permissions' => $permissions
            ]
        ];
    }

    private function getRoleAndPermission ($user) {
        $roleData = [];
        $permissionData = [];
        if (!empty($user)) {
            $roles = $user->getRoleNames();
            $permissions = $user->getAllPermissions();
            foreach ($roles as $role) {
                if (empty($role)) {
                    continue;
                }

                $roleData[] = $role;
            }

            foreach ($permissions as $permission) {
                if (empty($permission['name'])) {
                    continue;
                }

                $permissionData[] = $permission['name'];
            }
        }

        return [$roleData, $permissionData];
    }
}
