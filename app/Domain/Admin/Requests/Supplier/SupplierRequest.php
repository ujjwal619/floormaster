<?php

namespace App\Domain\Admin\Requests\Supplier;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest implements IFormRequest
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
        // $supplierId = request()->segment(2) ?? '0';

        return [
            'site_id' => 'required|numeric',
            'trading_name' => 'required',
            // 'trading_name' => 'required|unique:tbl_suppliers,trading_name,'. $supplierId,
        ];
    }
}
