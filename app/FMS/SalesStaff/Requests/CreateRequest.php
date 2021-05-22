<?php

namespace App\FMS\SalesStaff\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'is_active' => 'required|boolean',
            'commission_calculation' => 'required',
            'first_tier' => 'array',
            'second_tier' => 'array',
            'third_tier' => 'array'
        ];
    }
}
