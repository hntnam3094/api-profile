<?php
namespace App\Constants;

use App\Constants\Forms\Posttype\BookingConstant;
use App\Constants\Forms\Posttype\ProductConstant;

class PostTypeConstant {
    public const code = 'code';
    public const name = 'name';
    public const fieldSearch = 'search';
    public const fieldForm = 'form';
    public const fieldTaxonomy = 'taxonomy';
    public const fieldList = 'list';

    public const FORM = [
        [
            self::code => ProductConstant::CODE,
            self::name => ProductConstant::NAME,
            self::fieldSearch => ProductConstant::SEARCH,
            self::fieldForm => ProductConstant::FORM,
            self::fieldTaxonomy => ProductConstant::TAXONOMY,
            self::fieldList => ProductConstant::LIST
        ],
        [
            self::code => BookingConstant::CODE,
            self::name => BookingConstant::NAME,
            self::fieldSearch => BookingConstant::SEARCH,
            self::fieldForm => BookingConstant::FORM,
            self::fieldTaxonomy => BookingConstant::TAXONOMY,
            self::fieldList => BookingConstant::LIST
        ]
    ];

    public static function getForm ($code = '', $isShowDefault = true, $field = '') {
        if(empty($code)) {
            $listForm = [];
            foreach(self::FORM as $key => $form) {
                $listForm[$key] = array_merge($form, self::DEFAULT_FORM);
            }
            return $listForm;
        }

        $formByCode = [];
        foreach(self::FORM as $form) {
            if ($form[self::code] == $code) {
                $formByCode = $form;
                break;
            }
        }

        if (!empty($field)) {
            return $formByCode[$field];
        }

        if (!$isShowDefault) {
            return $formByCode;
        }

        if (!empty($formByCode[self::fieldForm]) && $isShowDefault) {
            $formByCode[self::fieldForm] = array_merge($formByCode[self::fieldForm], self::DEFAULT_FORM);
        }

        return $formByCode;
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
}
