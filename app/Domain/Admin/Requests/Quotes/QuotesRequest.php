<?php

namespace App\Domain\Admin\Requests\Quotes;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CustomerRequest
 * @package App\Domain\Admin\Requests\Customers
 */
class QuotesRequest extends FormRequest implements IFormRequest
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
            'customerDetails.trading_name' => 'required',
            'quote.project'                => 'required',
            'selectedSales'                => 'required',
            'materials'                    => 'required',
            'labours'                      => 'required',
            'quote.job_source_id'          => 'required',
            'quote.site_id'                 =>'required',
            'quote.sales_code_id'           => 'required',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'quote.project'          => 'Project',
            'quote.remarks'          => 'Remarks',
            'quote.metadata.terms'   => 'Terms',
            'quote.metadata.deposit' => 'Deposit',
            'quote.job_source_id'    => 'Job Source',
            'quote.customer_id'      => 'Customer',
        ];

    }
}
