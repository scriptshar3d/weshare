<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	    'title' => 'string',
            'text' => 'required_without:media_url',
            'media_url' => 'required_without:text',
            'category_id' => 'required',
            'type' => ['required', Rule::in(config('constants.enums.post_type'))]
        ];
    }
}
