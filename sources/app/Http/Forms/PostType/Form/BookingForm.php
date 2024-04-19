<?php
namespace App\Http\Forms\PostType\Form;

use App\Constants\OptionConstant;
use App\Constants\PostTypeConstant;

class BookingForm {
    public $code = PostTypeConstant::BOOKING_CODE;
    public $name = PostTypeConstant::BOOKING_NAME;
    public $hasCategory = PostTypeConstant::BOOKING_CATEGORY;

    public $fieldSearch = [
        [
            'type' => 'text',
            'name' => 'title',
            'label' => 'Title',
            'value' => '',
            'placeholder' => 'Enter your title',
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
            'name' => 'title',
            'label' => 'Title',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'image',
            'name' => 'banner',
            'label' => 'Banner',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ]
    ];

    public $fieldList = [
        [
            'type' => 'text',
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'type' => 'image',
            'key' => 'banner',
            'name' => 'Banner'
        ],
    ];
}
