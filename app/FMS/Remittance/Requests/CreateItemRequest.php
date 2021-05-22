<?php

namespace App\FMS\Remittance\Requests;

use App\FMS\Remittance\ValueObjects\DefaultItemStatus;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\FMS\Remittance\ValueObjects\RemittanceType;
use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_amount' => 'required|numeric',

        ];
    }
}
