<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;
use App\Constants\OptionConstant;

class HomeStoryForm {
    public $pageCode = FormConstant::HOME;
    public $code = FormConstant::HOME_STORY;

    public $fieldList = [
        [
            'type' => 'text',
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'type' => 'image',
            'key' => 'image',
            'name' => 'Image'
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
            'type' => 'image',
            'name' => 'image_in_list_1',
            'label' => 'Image in list 1',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'image',
            'name' => 'image_in_list_2',
            'label' => 'Image in list 2',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'image',
            'name' => 'image_in_list_3',
            'label' => 'Image in list 3',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'image',
            'name' => 'image_in_list_4',
            'label' => 'Image in list 4',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],

    ];
}
