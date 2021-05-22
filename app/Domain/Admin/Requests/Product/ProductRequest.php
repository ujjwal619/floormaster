<?php

namespace App\Domain\Admin\Requests\Product;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest implements IFormRequest
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
        $productId = request()->segment(2) ?? 0;

        return [
            'name' => 'required',
            'upc' => 'required|unique:tbl_products,upc,'. $productId,
            'supplier_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'variants' => 'required|array',
            'variants.*.name' => 'required',
            'list_cost' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'variants.required' => 'Colorways is required.'
        ];
    }
}
