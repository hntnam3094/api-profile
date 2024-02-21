<?php
namespace App\Constants;

use App\Constants\Forms\Posttype\BookingConstant;
use App\Constants\Forms\Posttype\ProductConstant;
use App\Models\Category;
use App\Models\CategoryMeta;

class PostTypeConstant {
    public const code = 'code';
    public const name = 'name';
    public const fieldSearch = 'search';
    public const fieldForm = 'form';
    public const fieldCategory = 'category';
    public const fieldList = 'list';
    public const fieldCategoryList = 'category_list';

    public const listCategory = 'listCategory';
    public const listTreeCategory = 'listTreeCategory';

    public const FORM = [
        [
            self::code => ProductConstant::CODE,
            self::name => ProductConstant::NAME,
            self::fieldSearch => ProductConstant::SEARCH,
            self::fieldForm => ProductConstant::FORM,
            self::fieldCategory => ProductConstant::CATEGORY,
            self::fieldList => ProductConstant::LIST,
            self::fieldCategoryList => ProductConstant::LIST_CATEGORY
        ],
        [
            self::code => BookingConstant::CODE,
            self::name => BookingConstant::NAME,
            self::fieldSearch => BookingConstant::SEARCH,
            self::fieldForm => BookingConstant::FORM,
            self::fieldCategory => BookingConstant::CATEGORY,
            self::fieldList => BookingConstant::LIST,
            self::fieldCategoryList => BookingConstant::LIST_CATEGORY
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

        if (!empty($formByCode[self::fieldCategory])) {
            foreach ($formByCode[self::fieldCategory] as &$category) {
                if (!empty($category['option'])) {
                    if ($category['option'] == self::listCategory) {
                        $category['option'] = self::getCategoriesByPostType($formByCode[self::code], $category['metaValue']);
                    }

                    if ($category['option'] == self::listTreeCategory) {
                        $options = [
                            [
                                'key' => '',
                                'value' => '- Select -'
                            ]
                        ];

                        $category['option'] = self::getTreeCategoriesByPostType($formByCode[self::code], $category['metaValue'], $options);
                    }

                    if (gettype($category['option']) != 'array') {
                        $category['option'] = [];
                    }
                }
            }
        }

        if (!empty($formByCode[self::fieldForm])) {
            foreach ($formByCode[self::fieldForm] as &$category) {
                if (!empty($category['option'])) {
                    if ($category['option'] == self::listCategory) {
                        $category['option'] = self::getCategoriesByPostType($formByCode[self::code], $category['metaValue']);
                    }

                    if ($category['option'] == self::listTreeCategory) {
                        $options = [
                            [
                                'key' => '',
                                'value' => '- Select -'
                            ]
                        ];

                        $category['option'] = self::getTreeCategoriesByPostType($formByCode[self::code], $category['metaValue'], $options);
                    }

                    if (gettype($category['option']) != 'array') {
                        $category['option'] = [];
                    }
                }
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

        if (!empty($formByCode[self::fieldCategory]) && $isShowDefault) {
            $formByCode[self::fieldCategory] = array_merge($formByCode[self::fieldCategory], self::DEFAULT_FORM);
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

    private static function getCategoriesByPostType ($postType, $value) {
        $category = Category::where('postType', $postType)->where('parentId', 0)->select('id')->get();
        $options = [
            [
                'key' => '',
                'value' => '- Select -'
            ]
        ];
        if (!empty($category)) {
            foreach ($category as $cate) {
                $cateMeta = CategoryMeta::where('categoryId', $cate->id)
                                ->where('metaKey', $value)
                                ->select('metaValue')->first();

                $options[] = [
                    'key' => $cate->id,
                    'value' => $cateMeta->metaValue
                ];
            }
        }
        return $options;
    }

    private static function getTreeCategoriesByPostType ($postType, $value, &$options = [], $parentId = 0, $node = 0) {
        if (!empty($parentId)) {
            $node++;
        }

        $category = Category::where('postType', $postType)->where('parentId', $parentId)->select('id', 'parentId')->get();
        if (!empty($category)) {
            foreach ($category as $cate) {
                $cateMeta = CategoryMeta::where('categoryId', $cate->id)
                                ->where('metaKey', $value)
                                ->select('metaValue')->first();

                $options[] = [
                    'key' => $cate->id,
                    'value' => self::getPrefix($node) .' '. $cateMeta->metaValue,
                    'parentId' => $cate->parentId
                ];

                self::getTreeCategoriesByPostType($postType, $value, $options, $cate->id, $node);
            }
        }

        return $options;
    }

    private static function getPrefix ($number) {
        $prefix = "";
        for ($i = 0; $i < $number; $i++) {
            $prefix .= "-";
        }

        return $prefix;
    }
}
