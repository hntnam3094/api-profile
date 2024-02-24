<?php

namespace App\Http\Requests;

use App\Constants\CommonConstant;
use App\Constants\PosttypeConstant;
use App\Http\Forms\PostType\PostTypeForm;
use Illuminate\Foundation\Http\FormRequest;

class PostTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postTypeForm = new PostTypeForm();
        $validator = [];
        $postType = $this->input('posttype');

        if (!empty($postType)) {
            $postTypeForm = $postTypeForm->getForm($postType, true, PosttypeConstant::fieldForm) ?? [];

            foreach($postTypeForm as $field) {
                $this->addValidator($field, $validator);
            }
        }

        return $validator;
    }

    private function addValidator ($field, &$validator) {
        if ($field['name'] === CommonConstant::IMAGES) {
            $this->checkValidatorImagesField($field, $validator);
        } else {
            $validator[$field['name']][] = $field['validate']['rules'] ?? [];
        }
    }

    private function checkValidatorImagesField ($field, &$validator) {
        $validator[$field['name']] = [
            $field['validate']['rules'],
            function ($attribute, $value, $fail) {
                if (count($value) > 0) {
                    foreach ($value as $val) {
                        if (empty($val[CommonConstant::IMAGE])) {
                            return $fail('The ' . $attribute . ' field is required.');
                        }
                    }
                }
            }
        ];
    }
}
