<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;
use App\Constants\OptionConstant;

class SliderTopForm {
    public $pageCode = FormConstant::HOME;
    public $code = FormConstant::HOME_SLIDER;
    public $fieldList = [
        [
            'type' => 'text',
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'type' => 'image',
            'key' => 'image_cover',
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
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'text',
            'name' => 'sub_title',
            'label' => 'Sub title',
            'value' => '',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'image',
            'name' => 'image_cover',
            'label' => 'Image',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
    ];
}
