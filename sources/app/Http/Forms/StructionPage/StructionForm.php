<?php
namespace App\Http\Forms\StructionPage;

use App\Constants\OptionConstant;
use Illuminate\Support\Facades\File;

class StructionForm {
    private $form = [];
    private $listShow = [];
    private $searchForm = [];

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
                        $this->form[$formInstance->pageCode][$formInstance->code] = $formInstance->form ?? [];
                        $this->listShow[$formInstance->pageCode][$formInstance->code] = $formInstance->listShow ?? [];
                        $this->searchForm[$formInstance->pageCode][$formInstance->code] = $formInstance->searchForm ?? [];
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

        if (!empty($formByCode) && $isShowDefault) {
            return array_merge($formByCode, $this->defautlForm);
        }
        return [];
    }

    public function getListShow ($pageCode = '', $code = '') {
        return $this->listShow[$pageCode][$code] ?? [];
    }

    public function getSearchForm ($pageCode = '', $code = '') {
        return $this->searchForm[$pageCode][$code] ?? [];
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
