<?php
namespace App\Constants;

class PermissionConstant {
    public const SYSTEM_ADMIN = 'system-admin';
    public const ADMIN_EMAIL = 'admin@gmail.com';

    public const ROLE = [
        [
            'name' => self::SYSTEM_ADMIN
        ],
        [
            'name' => 'admin'
        ],
        [
            'name' => 'member'
        ]
    ];

    public const PERMISSION = [
        [
            'name' => 'developer',
            'action' => [
                'add', 'view', 'edit', 'delete'
            ]
        ],
        [
            'name' => 'permission',
            'action' => [
                'add', 'view', 'edit', 'delete'
            ]
        ],
    ];
}
