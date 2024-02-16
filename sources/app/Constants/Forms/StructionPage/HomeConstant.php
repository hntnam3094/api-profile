<?php
namespace App\Constants\Forms\StructionPage;

class HomeConstant {
    public const SLIDER_TOP = [
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
}
