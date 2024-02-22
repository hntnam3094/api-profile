<?php

namespace App\Http\Requests;

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
                $validator[$field['name']] = $field['validate']['rules'] ?? [];
            }

        }

        return $validator;
    }
}
