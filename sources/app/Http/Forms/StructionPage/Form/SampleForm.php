<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;
use App\Constants\OptionConstant;

class SampleForm {
    public $pageCode = FormConstant::SAMPLE;

    public $form = [
        [
            'type' => 'text',
            'name' => 'title',
            'label' => 'Title',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'image',
            'name' => 'image',
            'label' => 'Image',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'text',
            'name' => 'link',
            'label' => 'Link',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
        ],
        [
            'type' => 'images',
            'name' => 'listImage',
            'label' => 'List Image',
            'value' => [],
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'textarea',
            'name' => 'description',
            'label' => 'Description',
            'value' => '',
            'rows' => 5,
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'datepicker',
            'name' => 'date',
            'label' => 'Date',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'select',
            'name' => 'status',
            'label' => 'Status',
            'value' => '',
            'option' => [
                            [
                                'key' => '',
                                'value' => '-'
                            ],
                            ...OptionConstant::defaultStatus
                        ],
            'validate' => [
                'rules' => 'required'
            ],
        ],
        [
            'type' => 'checkbox',
            'name' => 'checkbox',
            'label' => 'Checkbox',
            'value' => 0,
            'option' => OptionConstant::defaultStatus,
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'radio',
            'name' => 'radio',
            'label' => 'Radio',
            'value' => 0,
            'option' => OptionConstant::defaultStatus,
            'validate' => [
                'rules' => 'required'
            ]
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
