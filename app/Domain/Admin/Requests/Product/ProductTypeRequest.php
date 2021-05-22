<?php

namespace App\Domain\Admin\Requests\Product;

use App\Constants\DBTable;
use App\Constants\General;
use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductTypeRequest
 * @package App\Domain\Admin\Requests\Product
 */
class ProductTypeRequest extends FormRequest implements IFormRequest
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
        $rules = $this->getRules(request()->route('product_type'));

        return $rules;
    }

    /**
     * Return rules according to product type.
     *
     * @param $productType
     * @return array
     */
    private function getRules(string $productType): array
    {
        $floatRegex = "/^\d*\.?\d*$/";
        if ($productType == General::MATERIAL) {
            $rules = [
                'product_type.name'          => 'required',
                'product_type.unit_cost'     => 'required|regex:'.$floatRegex,
                'product_type.is_featured'   => 'required|boolean',
                'product_type.category_id'   => 'required|exists:'.DBTable::PRODUCT_CATEGORIES.',id',
                'variants'                   => 'nullable|array',
            ];
        } elseif ($productType == General::LABOUR) {
            $rules = [
                'product_type.name'        => 'required',
                'product_type.unit_cost'   => 'required|regex:'.$floatRegex,
                'product_type.category_id' => 'required|exists:'.DBTable::PRODUCT_CATEGORIES.',id',
                'variants'                 => 'nullable|array',
            ];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'product_type.name'        => 'product type Name',
            'product_type.unit_cost'   => 'unit cost',
            'product_type.category_id' => 'category',
        ];
    }
}
