<?php

namespace App\Domain\Admin\Requests\User;

use App\Constants\DBTable;
use App\Infrastructure\Helpers\SelectListHelper;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UsersRequest
 * @package App\Domain\Admin\Requests\User
 */
class UsersRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $userId = request()->segment(2) ?? '1';
        $roleIds = implode(array_keys(app(SelectListHelper::class)->getAllRolesNameAndIdForDropDown()->toArray()), ',');
        $rules = [
            'full_name.first_name' => 'required|min:3|max:255',
            'full_name.last_name'  => 'required|min:3|max:255',
            'role'                 => 'required|in:'.$roleIds,
            'email'                => 'required|email|unique:'.DBTable::AUTH_USERS.',email,'.$userId,
            'username'             => 'required|unique:'.DBTable::AUTH_USERS.',username,'.$userId,
        ];
        if(strtolower(request()->method()) == 'post') {
            $rules['password'] = 'required|min:6';
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'full_name.first_name' => 'First Name',
            'full_name.last_name'  => "Last Name",
        ];
    }
}