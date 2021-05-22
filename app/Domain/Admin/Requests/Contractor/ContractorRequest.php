<?php

namespace App\Domain\Admin\Requests\Contractor;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContractorRequest extends FormRequest implements IFormRequest
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
            'site_id' => 'required|numeric',
            'tfn' => [
                'required',
                \Illuminate\Validation\Rule::unique('tbl_contractors', 'tfn')->ignore($this->route('contractor'))
            ]
        ];
    }
}
