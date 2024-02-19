<?php
namespace App\Constants\Forms\Posttype;

class ProductConstant {
    public const CODE = 'product';
    public const NAME = 'Product';

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
    public const TAXONOMY = [];
}
