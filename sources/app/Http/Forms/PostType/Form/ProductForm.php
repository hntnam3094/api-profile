<?php
namespace App\Http\Forms\PostType\Form;

use App\Constants\OptionConstant;
use App\Constants\PostTypeConstant;

class ProductForm {
    public $code = PostTypeConstant::PRODUCT_CODE;
    public $name = PostTypeConstant::PRODUCT_NAME;
    public $hasCategory = PostTypeConstant::PRODUCT_CATEGORY;

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
            'name' => PostTypeConstant::fieldCategory,
            'label' => 'Category',
            'value' => '',
            'option' => PostTypeConstant::listTreeCategory,
            'metaValue' => 'title',
            'validate' => [
                'rules' => 'required'
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

    public $fieldForm = [
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
            'type' => 'text',
            'name' => 'link',
            'label' => 'Link',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
        ],
        [
            'type' => 'select',
            'name' => PostTypeConstant::fieldCategory,
            'label' => 'Category',
            'value' => '',
            'option' => PostTypeConstant::listTreeCategory,
            'metaValue' => 'title',
            'validate' => [
                'rules' => 'required'
            ],
        ],
    ];

    public $fieldCategory = [
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
            'value' => [],
            'validate' => [
                'rules' => 'required'
            ]
        ],
        [
            'type' => 'select',
            'name' => 'parentId',
            'label' => 'Parent Category',
            'value' => '',
            'option' => PostTypeConstant::listTreeCategory,
            'metaValue' => 'title',
            'validate' => [],
        ],
    ];

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

    public $fieldCategoryList = [
        [
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'key' => 'image',
            'name' => 'Image'
        ],
    ];
}
