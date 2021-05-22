<?php

namespace App\FMS\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|min:3|unique:auth_users,username',
            'password' => 'required|min:3',
            'stores' => 'array'
        ];
    }
}
