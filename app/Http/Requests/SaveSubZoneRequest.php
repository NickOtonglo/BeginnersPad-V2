<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSubZoneRequest extends FormRequest
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
            'name' => 'required',
            'lat' => 'required|decimal:3,8',
            'lng' => 'required|decimal:3,8',
            'radius' => 'required|numeric',
            'nature_id' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
            'nature_id' => 'role',
        ];
    }
}
