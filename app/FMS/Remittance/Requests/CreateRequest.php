<?php

namespace App\FMS\Remittance\Requests;

use App\FMS\Remittance\ValueObjects\DefaultItemStatus;
use App\FMS\Remittance\ValueObjects\PaymentType;
use App\FMS\Remittance\ValueObjects\RemittanceType;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'remittance_type' => 'required|numeric|in:'. implode(',', [RemittanceType::AUTO_PAY, RemittanceType::MANUAL_PAY, RemittanceType::PAY_THIS_RECORD]),
            'default_item_status' => 'required|numeric|in:'. implode(',', [DefaultItemStatus::PAY, DefaultItemStatus::HOLD]),
            'payment_type' => 'required|numeric|in:'. implode(',', [PaymentType::CHEQUE, PaymentType::EFT]),
            'transaction_date' => 'sometimes|date',
            'cheque_date' => 'nullable|date',
            'invoice_date' => 'nullable|date',
            'supplier_id' => 'nullable|numeric',
            'notes' => 'array'
        ];
    }
}
