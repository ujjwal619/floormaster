<?php

namespace App\Domain\Admin\Requests\Stock;

use App\StartUp\Contracts\IFormRequest;
use Arcanedev\Support\Http\FormRequest;

class UpdateFutureStockRequest extends FormRequest implements IFormRequest
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
            'quantity' => 'required',
            'list_price' => 'required',
            'delivery_date' => 'required',
        ];
    }
}
