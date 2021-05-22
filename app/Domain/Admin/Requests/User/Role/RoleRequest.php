<?php

namespace App\Domain\Admin\Requests\User\Role;


use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RoleRequest
 * @package App\Domain\Admin\Requests\User\Role
 */
class RoleRequest extends FormRequest implements IFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'name'  => 'required|min:3',
        ];
    }
}
