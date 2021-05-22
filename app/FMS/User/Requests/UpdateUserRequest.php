<?php

namespace App\FMS\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'sometimes',
                'required',
                'min:3',
                Rule::unique('auth_users', 'username')->ignore($this->route('userId'))
            ],
            'password' => 'sometimes|required|min:3',
            'stores' => 'array'
        ];
    }
}
