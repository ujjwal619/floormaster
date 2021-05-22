<?php

namespace App\Domain\Admin\Requests\Product;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StockRequest
 * @package App\Domain\Admin\Requests\Product
 */
class StockRequest extends FormRequest Implements IFormRequest
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
            'batch'         => 'required',
            'unit_cost'     => 'required|numeric',
            'levy'          => 'required|numeric|min:0|max:100',
            'selling_price' => 'required|numeric',
            'received_date' => 'required|date',
            'gl_date'       => 'required|date',
        ];
    }
}
