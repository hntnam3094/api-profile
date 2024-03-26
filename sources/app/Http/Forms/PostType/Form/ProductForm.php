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
            'type' => 'number',
            'name' => 'price',
            'label' => 'Price',
            'value' => '',
            'placeholder' => 'Enter your price',
            'validate' => [
                'rules' => ['required']
            ]
        ],
        [
            'type' => 'image',
            'name' => 'avatar',
            'label' => 'Image',
            'value' => [],
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
            'type' => 'images',
            'name' => 'list_image',
            'label' => 'Images',
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
            'name' => 'image',
            'label' => 'Image',
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
            'key' => 'avatar',
            'name' => 'Avatar'
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
            'key' => 'image',
            'name' => 'Image'
        ],
    ];
}
