<?php
namespace App\Http\Forms\PostType;

use App\Constants\OptionConstant;
use App\Constants\PostTypeConstant;
use App\Models\Category;
use App\Models\CategoryMeta;
use Illuminate\Support\Facades\File;

class PostTypeForm {

    public $code = 'code';
    public $name = 'name';
    public $fieldSearch = 'search';
    public $fieldForm = 'form';
    public $fieldCategory = 'category';
    public $fieldList = 'list';
    public $fieldCategoryList = 'category_list';
    public $listCategory = 'listCategory';
    public $listTreeCategory = 'listTreeCategory';

    private $form = [];

    public function __construct()
    {
        $this->loadForms();
    }

    public function loadForms () {
        $structionFormpath = app_path('Http/Forms/PostType/Form');
        if (File::isDirectory($structionFormpath)) {
            $structionForm = File::allFiles($structionFormpath);

            foreach ($structionForm as $key => $file) {
                $namespace = 'App\\Http\\Forms\\PostType\\Form\\';
                $class = $file->getBasename('.php');
                $className = $namespace . $class;

                if (class_exists($className)) {
                    $formInstance = new $className();
                    $this->form[$key][$this->code] = $formInstance->code ?? '';
                    $this->form[$key][$this->name] = $formInstance->name ?? '';
                    $this->form[$key][$this->fieldSearch] = $formInstance->fieldSearch ?? [];
                    $this->form[$key][$this->fieldForm] = $formInstance->fieldForm ?? [];
                    $this->form[$key][$this->fieldCategory] = $formInstance->fieldCategory ?? [];
                    $this->form[$key][$this->fieldList] = $formInstance->fieldList ?? [];
                    $this->form[$key][$this->fieldCategoryList] = $formInstance->fieldCategoryList ?? [];
                }
            }
        }
    }

    public function getForm ($code = '', $isShowDefault = true, $field = '') {
        $listCheckCategory = [
            $this->fieldCategory,
            $this->fieldForm,
            $this->fieldSearch
        ];

        if(empty($code)) {
            $listForm = [];
            foreach($this->form as $key => $form) {
                $listForm[$key] = array_merge($form, $this->defautlForm);
            }
            return $listForm;
        }

        $formByCode = [];
        foreach($this->form as $form) {
            if ($form[$this->code] == $code) {
                $formByCode = $form;
                break;
            }
        }

        foreach ($listCheckCategory as $itemCheck) {
            if (!empty($formByCode[$itemCheck])) {
                foreach ($formByCode[$itemCheck] as &$category) {
                    if (!empty($category['option']) && gettype($category['option']) != 'array') {
                        if ($category['option'] == $this->listCategory) {
                            $category['option'] = $this->getCategoriesByPostType($formByCode[$this->code], $category['metaValue']);
                        }

                        if ($category['option'] == $this->listTreeCategory) {
                            $options = [
                                [
                                    'key' => '',
                                    'value' => '- Select -'
                                ]
                            ];

                            $category['option'] = $this->getTreeCategoriesByPostType($formByCode[$this->code], $category['metaValue'], $options);
                        }
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

        if (!empty($formByCode[$this->fieldForm]) && $isShowDefault) {
            $formByCode[$this->fieldForm] = array_merge($formByCode[$this->fieldForm], $this->defautlForm);
        }

        if (!empty($formByCode[$this->fieldCategory]) && $isShowDefault) {
            $formByCode[$this->fieldCategory] = array_merge($formByCode[$this->fieldCategory], $this->defautlForm);
        }

        $defaultData = [];
        foreach ($listCheckCategory as $checkItem) {
            if (!empty($formByCode[$checkItem])) {
                foreach ($formByCode[$checkItem] as $itemCategory) {
                    $defaultData[$checkItem][$itemCategory['name'] ?? ''] = isset($itemCategory['value']) ? $itemCategory['value'] : '';
                }
            }
        }
        $formByCode[PostTypeConstant::defaultData] = $defaultData;

        return $formByCode;
    }

    private function getCategoriesByPostType ($postType, $value) {
        $category = Category::where('postType', $postType)->where('parentId', 0)->where('status', OptionConstant::ACTIVE)->select('id')->get();
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

    private function getTreeCategoriesByPostType ($postType, $value, &$options = [], $parentId = 0, $node = 0) {
        if (!empty($parentId)) {
            $node++;
        }

        $category = Category::where('postType', $postType)->where('parentId', $parentId)->where('status', OptionConstant::ACTIVE)->select('id', 'parentId')->get();
        if (!empty($category)) {
            foreach ($category as $cate) {
                $cateMeta = CategoryMeta::where('categoryId', $cate->id)
                                ->where('metaKey', $value)
                                ->select('metaValue')->first();
                if (empty($cateMeta)) {
                    continue;
                }
                $options[] = [
                    'key' => $cate->id,
                    'value' => $this->getPrefix($node) .' '. $cateMeta->metaValue,
                    'parentId' => $cate->parentId
                ];

                $this->getTreeCategoriesByPostType($postType, $value, $options, $cate->id, $node);
            }
        }

        return $options;
    }

    private function getPrefix ($number) {
        $prefix = "";
        for ($i = 0; $i < $number; $i++) {
            $prefix .= "-";
        }

        return $prefix;
    }

    public $defautlForm = [
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
