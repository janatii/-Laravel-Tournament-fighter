<?php

namespace App\Http\Requests;

use App\Helpers\Facades\LocalizationFormats;
use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'username' => 'required|string|min:4|max:15|alpha_dash|unique:users,username,' . $this->user->id,
            'firstname' => 'present|nullable|string|max:255',
            'lastname' => 'present|nullable|string|max:255',
            'birthdate' => 'present|nullable|date_format:' . LocalizationFormats::getFormat('date') . '|before:' . date('Y-m-d'),
            'email' => 'required|max:255|email|unique:users,email,' . $this->user->id,
            'password' => 'present|nullable|password',
            'credits' => 'required|integer|min:0',
            'roles' => 'array',
            'avatar' => 'image|mimes:jpeg,jpg,png',
            'force_email_confirmation' => 'filled|boolean',
        ];
    }
}
