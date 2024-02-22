<?php
namespace App\Http\Forms\StructionPage\Form;

use App\Constants\FormConstant;

class HomeStoryForm {
    public $pageCode = FormConstant::HOME;
    public $code = FormConstant::HOME_STORY;

    public $form = [
        [
            'type' => 'text',
            'name' => 'title',
            'label' => 'Title',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
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
            'type' => 'textarea',
            'name' => 'summary',
            'label' => 'Sumary',
            'value' => '',
            'validate' => [
                'rules' => 'required'
            ],
        ],
    ];
}
