<?php
namespace App\Http\Forms\PostType\Form;

use App\Constants\OptionConstant;
use App\Constants\PostTypeConstant;

class BlogForm {
    public $code = PostTypeConstant::BLOG_CODE;
    public $name = PostTypeConstant::BLOG_NAME;
    public $hasCategory = PostTypeConstant::BLOG_CATEGORY;

    public $fieldSearch = [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Name',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => []
        ],
        [
            'type' => 'select',
            'name' => PostTypeConstant::fieldCategory,
            'label' => 'Category',
            'value' => '',
            'option' => PostTypeConstant::listTreeCategory,
            'metaValue' => 'name',
            'validate' => [],
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
            'label' => 'Name',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'text',
            'name' => 'slug',
            'label' => 'Slug',
            'value' => '',
            'slugOfField' => 'name',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'textarea',
            'name' => 'description',
            'label' => 'Description',
            'value' => '',
            'placeholder' => 'Enter your description',
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
        ],
        [
            'type' => 'editor',
            'name' => 'content',
            'label' => 'Content',
            'value' => [],
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'select',
            'name' => PostTypeConstant::fieldCategory,
            'label' => 'Category',
            'value' => '',
            'option' => PostTypeConstant::listTreeCategory,
            'metaValue' => 'name',
            'validate' => [
                'rules' => ['required']
            ],
        ],
    ];

    public $fieldCategory = [
        [
            'type' => 'text',
            'name' => 'name',
            'label' => 'Name',
            'value' => '',
            'placeholder' => 'Enter your title',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'text',
            'name' => 'description',
            'label' => 'Description',
            'value' => '',
            'placeholder' => 'Enter your description',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'text',
            'name' => 'slug',
            'label' => 'Slug',
            'value' => '',
            'slugOfField' => 'name',
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
            'key' => 'name',
            'name' => 'Name'
        ],
        [
            'type' => 'image',
            'key' => 'banner',
            'name' => 'Banner'
        ],
    ];

    public $fieldCategoryList = [
        [
            'type' => 'text',
            'key' => 'name',
            'name' => 'Name'
        ],
        [
            'type' => 'image',
            'key' => 'banner',
            'name' => 'Banner'
        ],
    ];
}
