<?php
namespace App\Http\Forms\DymanicForm;

use App\Constants\DymanicFormConstant;
use App\Constants\OptionConstant;
use App\Http\Forms\DymanicOptions;

class UserForm extends BaseForm {
    public $code = DymanicFormConstant::USER_CODE;
    public $name = DymanicFormConstant::USER_NAME;
    public $hasCategory = DymanicFormConstant::USER_CATEGORY;

    public $fieldSearch = [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Name',
            'value' => '',
            'placeholder' => 'Enter your name',
            'validate' => []
        ],
        [
            'type' => 'select',
            'name' => 'status',
            'label' => 'Status',
            'value' => 1,
            'option' => OptionConstant::defaultStatus,
            'validate' => [],
        ],
    ];

    public $fieldForm = [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'User name',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'text',
            'name' => 'email',
            'label' => 'User email',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'select',
            'name' => 'role',
            'label' => 'Role',
            'value' => '',
            'option' => 'roleOptions',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'select',
            'name' => 'status',
            'label' => 'Status',
            'value' => 1,
            'option' => OptionConstant::defaultStatus,
            'validate' => [],
        ],
    ];

    public $fieldCategory = [];
}
