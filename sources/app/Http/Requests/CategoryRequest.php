<?php

namespace App\Http\Requests;

use App\Constants\PosttypeConstant;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validator = [];
        $postType = $this->input('posttype');

        if (!empty($postType)) {
            $postTypeForm = PostTypeConstant::getForm($postType, true, PosttypeConstant::fieldCategory) ?? [];

            foreach($postTypeForm as $field) {
                $validator[$field['name']] = $field['validate']['rules'] ?? [];
            }

        }

        return $validator;
    }
}
