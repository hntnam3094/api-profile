<?php
namespace App\Constants;

class OptionConstant {
    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const defaultStatus = [
        [
            'key' => self::INACTIVE,
            'value' => 'Inactive'
        ],
        [
            'key' => self::ACTIVE,
            'value' => 'Active'
        ]
    ];
}
