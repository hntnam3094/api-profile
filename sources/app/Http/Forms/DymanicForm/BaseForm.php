<?php
namespace App\Http\Forms\DymanicForm;

use App\Http\Forms\DymanicOptions;

class BaseForm {


    public $code = '';
    public $name = '';
    public $fieldSearch = [];
    public $fieldForm = [];
    public $fieldCategory = [];

    private $form = [];


    public function __construct()
    {
        $this->loadForms();
    }

    public function loadForms () {
        $this->form['code'] = $this->code ?? '';
        $this->form['name'] = $this->name ?? '';
        $this->form['search'] = $this->fieldSearch ?? [];
        $this->form['form'] = $this->fieldForm ?? [];
        $this->form['category'] = $this->fieldCategory ?? [];
    }

    public function getForm () {
        foreach ($this->form as &$form) {
            if (!is_array($form)) {
                continue;
            }

            foreach ($form as &$field) {
                if (!isset($field['option'])) {
                    continue;
                }

                if (is_string($field['option']) && method_exists(DymanicOptions::class, $field['option'])) {
                    $methodName = $field['option'];
                    $field['option'] = DymanicOptions::$methodName();
                }
            }
        }
        return $this->form;
    }
}
