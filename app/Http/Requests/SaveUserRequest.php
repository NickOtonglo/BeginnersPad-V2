<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fname' => 'required|min:1|max:50',
            'lname' => 'required|min:1|max:50',
            'email' => 'required|email',
            'telephone' => 'required|regex:/(254)[0-9]{9}/|unique:users,telephone',
            // https://stackoverflow.com/q/4424179/11113076
            'username' => 'required|max:50|unique:users,username|regex:/^[A-Za-z0-9_-]{1,15}$/',
            'user_type' => 'required|max:50',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|',
            'terms_agree' => 'required|accepted',
        ];
    }

    public function attributes()
    {
        return [
            'fname' => 'first name',
            'lname' => 'last name',
            'telephone' => 'phone number',
            'user_type' => 'account type',
            'terms_agree' => 'terms and conditions',
        ];
    }
}
