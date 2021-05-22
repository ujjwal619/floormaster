<?php

namespace App\Domain\Admin\Requests\Stock;

use App\StartUp\Contracts\IFormRequest;
use Arcanedev\Support\Http\FormRequest;

class UpdateCurrentStockRequest extends FormRequest implements IFormRequest
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
            'batch' => 'required',
            'roll_no' => 'required',
            'size' => 'required',
            'supplier_inv_no' => 'required'
        ];
    }
}
