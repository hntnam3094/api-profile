<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;
use App\Constants\OptionConstant;

class HomeStoryForm {
    public $pageCode = FormConstant::HOME;
    public $code = FormConstant::HOME_STORY;

    public $fieldList = [
        [
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'key' => 'image',
            'name' => 'Image'
        ],
    ];

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

    public $form = [
        [
            'type' => 'text',
            'name' => 'title',
            'label' => 'Title',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
        ],
        [
            'type' => 'image',
            'name' => 'image',
            'label' => 'Image',
            'value' => [],
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'images',
            'name' => 'images',
            'label' => 'Images',
            'value' => [],
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'textarea',
            'name' => 'summary',
            'label' => 'Sumary',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
        ],
    ];
}
