<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageEditRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'lang' => 'required|string|size:2',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'visible_in_menu' => 'boolean',
            'content' => 'required|string',
        ];
    }
}
