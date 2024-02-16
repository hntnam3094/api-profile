<?php

namespace App\Constants;

use App\Constants\Forms\StructionPage\HomeConstant;
class FormConstant
{
    public const HOME = 'home';
    public const HOME_SLIDER = 'slider_top';
    public const HOME_STORY = 'home_story';

    public const SAMPLE = 'sample';

    public const FORM = [
        self::HOME => [
            self::HOME_SLIDER => HomeConstant::SLIDER_TOP,
            self::HOME_STORY => []
        ],
        self::SAMPLE => self::SAMPLE_FORM
    ];

    public static function getForm ($pageCode = '', $code = '', $isShowDefault = true) {
        if(empty($pageCode) && empty($code)) {
            $listForm = [];
            foreach(self::FORM as $key => $form) {
                $listForm[$key] = array_merge($form, self::DEFAULT_FORM);
            }
            return $listForm;
        }

        $formByCode = self::FORM[$pageCode][$code] ?? [];
        if (empty($code)) {
            $formByCode = self::FORM[$pageCode] ?? [];
            $isShowDefault = false;
        }

        if (!$isShowDefault) {
            return $formByCode;
        }

        if (!empty($formByCode) && $isShowDefault) {
            return array_merge($formByCode, self::DEFAULT_FORM);
        }
        return [];
    }

    private const DEFAULT_FORM = [
        [
            'type' => 'text',
            'name' => 'meta_title',
            'label' => 'Meta title',
            'value' => '',
            'validate' => []
        ],
        [
            'type' => 'text',
            'name' => 'meta_description',
            'label' => 'Meta description',
            'value' => '',
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
        [
            'type' => 'text',
            'name' => 'sequence',
            'label' => 'Sequence',
            'value' => 0,
            'validate' => []
        ],
    ];

    private const SAMPLE_FORM = [
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
