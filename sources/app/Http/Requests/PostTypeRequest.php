<?php

namespace App\Http\Requests;

use App\Constants\CommonConstant;
use App\Constants\PosttypeConstant;
use App\Http\Forms\PostType\PostTypeForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
                    $meta = DB::table('post_meta')
                            ->where('postDetailId', '!=', $id)
                            ->where('metaKey', CommonConstant::SLUG)
                            ->where('metaValue', $value)->first();

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
