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
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'text',
            'name' => 'title_1',
            'label' => 'Title 1',
            'value' => '',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'textarea',
            'name' => 'sub_title_1',
            'label' => 'Sub title 1',
            'value' => '',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'image',
            'name' => 'image_1',
            'label' => 'Image 1',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'text',
            'name' => 'title_2',
            'label' => 'Title 2',
            'value' => '',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'textarea',
            'name' => 'sub_title_2',
            'label' => 'Sub title 2',
            'value' => '',
            'validate' => [
                'rules' => ['required']
            ],
        ],
        [
            'type' => 'image',
            'name' => 'image_2',
            'label' => 'Image 2',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
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
    ];
}
