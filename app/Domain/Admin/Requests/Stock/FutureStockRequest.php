<?php

namespace App\Domain\Admin\Requests\Stock;

use App\StartUp\Contracts\IFormRequest;
use Arcanedev\Support\Http\FormRequest;

class FutureStockRequest extends FormRequest implements IFormRequest
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
            'futureStocks.*.quantity' => 'required',
            'futureStocks.*.list_price' => 'required',
            'futureStocks.*.delivery_date' => 'required|date',
            'supplier_details' => 'array|required',
//            'supplier_details.placed_with' => 'required',
//            'supplier_details.name' => 'required',
//            'delivery_address' => 'array|required',
//            'supplier_reference' => 'required',
//            'interim_order_number' => 'required'
        ];
    }
}
