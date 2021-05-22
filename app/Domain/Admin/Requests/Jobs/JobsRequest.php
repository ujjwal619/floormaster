<?php

namespace App\Domain\Admin\Requests\Jobs;


use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class JobsRequest
 * @package App\Domain\Admin\Requests\Jobs
 */
class JobsRequest extends FormRequest implements IFormRequest
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
            'job.project'       => 'required',
            'job.sales_code_id'       => 'required',
            'selectedSales'     => 'required',
            'materials'         => 'required',
            'labours'           => 'required',
            'job.job_source_id' => 'required',
            'job.site_id'       => 'required',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'job.project'          => 'Project',
            'job.remarks'          => 'Remarks',
            'job.metadata.terms'   => 'Terms',
            'job.metadata.deposit' => 'Deposit',
            'job.job_source_id'    => 'Job Source',
            'job.customer_id'      => 'Customer',
        ];

    }
}
