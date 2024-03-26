<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;
use App\Constants\OptionConstant;

class AboutUsForm {
    public $pageCode = FormConstant::ABOUT_US;
    public $code = FormConstant::ABOUT_US;

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
            'type' => 'editor',
            'name' => 'content',
            'label' => 'Content',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ]
        ]

    ];
}
