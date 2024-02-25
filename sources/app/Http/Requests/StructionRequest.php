<?php

namespace App\Http\Requests;

use App\Constants\CommonConstant;
use App\Constants\FormConstant;
use App\Constants\StructionConstant;
use App\Http\Forms\StructionPage\StructionForm;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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

            foreach($structionForm[StructionConstant::fieldForm] as $field) {
                $this->addValidator($field, $validator);
            }

        }

        return $validator;
    }

    private function addValidator ($field, &$validator) {
        if ($field['name'] === CommonConstant::IMAGES) {
            $this->checkValidatorImagesField($field, $validator);
        } else if ($field['name'] == CommonConstant::SLUG) {
            $this->checkValidatorSlugField($field, $validator);
        } else {
            $validator[$field['name']] = $field['validate']['rules'] ?? [];
        }
    }

    private function checkValidatorSlugField ($field, &$validator) {
        $validator[$field['name']] = array_merge(
            $field['validate']['rules'],
            [
                function ($attribute, $value, $fail) {
                    $id = Route::current()->parameter('id');
                    $meta = DB::table('struction_metas')
                            ->where('structionDetailId', '!=', $id)
                            ->where('key', CommonConstant::SLUG)
                            ->where('value', $value)->first();

                    if($meta) {
                        return $fail('This ' . $attribute . ' is exist.');
                    }

                }
            ]
        );
    }

    private function checkValidatorImagesField ($field, &$validator) {
        $validator[$field['name']] = array_merge(
            $field['validate']['rules'],
            [
                function ($attribute, $value, $fail) {
                    if (count($value) > 0) {
                        foreach ($value as $val) {
                            if (empty($val[CommonConstant::IMAGE])) {
                                return $fail('The ' . $attribute . ' field is required.');
                            }
                        }
                    }
                }
            ]
        );
    }
}
