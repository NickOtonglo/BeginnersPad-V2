<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePropertyUnitBasicRequest extends FormRequest
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
            'price' => 'required|numeric',
            'init_deposit' => 'required|numeric',
            'init_deposit_period' => 'required|numeric',
            'floor_area' => 'required|numeric',
            'bathrooms' => 'required|numeric',
            'bedrooms' => 'required|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'price' => 'rent',
            'init_deposit' => 'initial deposit amount',
            'init_deposit_period' => 'initial deposit period',
        ];
    }
}
