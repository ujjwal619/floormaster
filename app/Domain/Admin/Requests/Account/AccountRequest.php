<?php

namespace App\Domain\Admin\Requests\Account;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest implements IFormRequest
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
            'family' => 'required|integer',
            'type' => 'required|integer',
            'site_id' => 'required|integer',
            'name' => 'required',
            'code' => 'required',
            'gst_applicable' => 'required|boolean',
            'reports_to' => new ValidateReportsTo(),
            'opening_balance' => 'nullable|numeric'
        ];
    }
}
