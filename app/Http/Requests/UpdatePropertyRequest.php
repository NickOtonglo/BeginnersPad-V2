<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
            'description' => 'required',
            'sub_zone_id' => 'required',
            'lat' => 'required|decimal:3,8',
            'lng' => 'required|decimal:3,8',
            'stories' => 'required|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'sub_zone_id' => 'sub_zone',
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }
}
