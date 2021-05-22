<?php

namespace App\Domain\Admin\Requests\Account;

use Illuminate\Contracts\Validation\Rule;

class ValidateReportsTo implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // check if not the first item in the family
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Reports to field is required.';
    }
}
