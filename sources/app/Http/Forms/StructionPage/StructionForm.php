<?php
namespace App\Http\Forms\StructionPage;

use App\Constants\OptionConstant;
use Illuminate\Support\Facades\File;

class StructionForm {
    public $fieldSearch = 'search';
    public $fieldForm = 'form';
    public $fieldList = 'list';

    private $form = [];

    public function __construct()
    {
        $this->loadForms();
    }

    public function loadForms () {
        $structionFormpath = app_path('Http/Forms/StructionPage/Form');
        if (File::isDirectory($structionFormpath)) {
            $structionForm = File::allFiles($structionFormpath);

            foreach ($structionForm as $key => $file) {
                $namespace = 'App\\Http\\Forms\\StructionPage\\Form\\';
                $class = $file->getBasename('.php');
                $className = $namespace . $class;

                if (class_exists($className)) {
                    $formInstance = new $className();

                    if (!empty($formInstance->pageCode) && !empty($formInstance->code)) {
                        $this->form[$formInstance->pageCode][$formInstance->code][$this->fieldForm] = $formInstance->form ?? [];
                        $this->form[$formInstance->pageCode][$formInstance->code][$this->fieldList] = $formInstance->fieldList ?? [];
                        $this->form[$formInstance->pageCode][$formInstance->code][$this->fieldSearch] = $formInstance->fieldSearch ?? [];
                    }

                    if (!empty($formInstance->pageCode) && empty($formInstance->code)) {
                        $this->form[$formInstance->pageCode] = $formInstance->form ?? [];
                    }


                }
            }
        }
    }

    public function getForm ($pageCode = '', $code = '', $isShowDefault = true) {

        if(empty($pageCode) && empty($code)) {
            $listForm = [];
            foreach($this->form as $key => $form) {
                $listForm[$key] = array_merge($form, $this->defautlForm);
            }
            return $listForm;
        }

        $formByCode = $this->form[$pageCode][$code] ?? [];
        if (empty($code)) {
            $formByCode = $this->form[$pageCode] ?? [];
            $isShowDefault = false;
        }

        if (!$isShowDefault) {
            return $formByCode;
        }

        if (!empty($formByCode[$this->fieldForm]) && $isShowDefault) {
            $formByCode[$this->fieldForm] = array_merge($formByCode[$this->fieldForm], $this->defautlForm);
        }
        return $formByCode;
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
