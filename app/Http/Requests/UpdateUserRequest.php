<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'firstname' => 'required|min:1|max:50',
            'lastname' => 'required|min:1|max:50',
            'email' => 'required|email',
            'telephone' => 'required|regex:/(254)[0-9]{9}/',
            // https://stackoverflow.com/q/4424179/11113076
            'username' => 'required|max:50|unique:users,username|regex:/^[A-Za-z0-9_-]{1,15}$/',
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'first name',
            'lastname' => 'last name',
            'telephone' => 'phone number',
        ];
    }
}
