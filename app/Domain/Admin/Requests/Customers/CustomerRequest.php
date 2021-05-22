<?php

namespace App\Domain\Admin\Requests\Customers;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CustomerRequest
 * @package App\Domain\Admin\Requests\Customers
 */
class CustomerRequest extends FormRequest implements IFormRequest
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
            'customer.trading_name'            => 'required|min:5',
            'customer.address.street'          => 'required',
            'customer.address.town'            => 'required',
            'customer.address.state'           => 'required',
            'customer.address.code'            => 'required',
            'customer.phone'                   => 'required',
            'customer.fax'                     => 'required',
            'customer.acn'                     => 'required',
            'customer.abn'                     => 'required',
            'customer.group_id'                => 'required',
            'customer.postal_address.street'   => 'required',
            'customer.postal_address.town'     => 'required',
            'customer.postal_address.state'    => 'required',
            'customer.postal_address.code'     => 'required',
            'customer.delivery_address.name'   => 'required',
            'customer.delivery_address.street' => 'required',
            'customer.delivery_address.town'   => 'required',
            'customer.delivery_address.state'  => 'required',
            'customer.delivery_address.code'   => 'required',
            'customer.delivery_address.phone'  => 'required',
            'customer.delivery_address.fax'    => 'required',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'customer.address.street'          => 'Address street',
            'customer.address.town'            => 'Address town',
            'customer.address.state'           => 'Address State',
            'customer.address.code'            => 'Address Code',
            'customer.phone'                   => 'Phone',
            'customer.postal_address.street'   => 'Postal address street ',
            'customer.postal_address.town'     => 'Postal address town',
            'customer.postal_address.state'    => 'Postal address state',
            'customer.postal_address.code'     => 'Postal address code',
            'customer.delivery_address.name'   => 'Delivery address name',
            'customer.delivery_address.street' => 'Delivery address street',
            'customer.delivery_address.town'   => 'Delivery address town',
            'customer.delivery_address.state'  => 'Delivery address state',
            'customer.delivery_address.code'   => 'Delivery address code',
            'customer.delivery_address.phone'  => 'Delivery address phone',
            'customer.delivery_address.fax'    => 'Delivery address fax',
        ];

    }
}