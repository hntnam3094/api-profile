<?php

namespace App\Http\Requests;

use App\Constants\FormConstant;
use App\Http\Forms\StructionPage\StructionForm;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StructionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $structionForm = new StructionForm();
        $validator = [];
        $pageCode = $this->input('page_code');
        $code = $this->input('code');

        if (!empty($pageCode) && !empty($code)) {
            $structionForm = $structionForm->getForm($pageCode, $code);

            foreach($structionForm as $field) {
                $validator[$field['name']] = $field['validate']['rules'] ?? [];
            }

        }
        return $validator;
    }
}
