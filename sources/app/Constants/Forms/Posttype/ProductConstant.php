<?php
namespace App\Constants\Forms\Posttype;

use App\Constants\OptionConstant;
use App\Constants\PostTypeConstant;

class ProductConstant {
    public const CODE = 'product';
    public const NAME = 'Product';
    public const HAS_CATEGORY = 1;

    public const LIST = [
        [
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'key' => 'image',
            'name' => 'Image'
        ],
    ];
    public const LIST_CATEGORY = [
        [
            'key' => 'title',
            'name' => 'Title'
        ],
        [
            'key' => 'image',
            'name' => 'Image'
        ],
    ];
    public const SEARCH = [];
    public const FORM = [
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
            'value' => [
                'link' => '',
                'alt' => '',
                'image' => []
            ],
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
    ];
    public const CATEGORY = [
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
            'option' => PostTypeConstant::listCategory,
            'metaValue' => 'title',
            'validate' => [
                'rules' => 'required'
            ],
        ],
    ];
}
