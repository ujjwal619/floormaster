<?php

namespace App\Domain\Admin\Requests\Settings\Terms;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TermsRequest
 * @package App\Domain\Admin\Requests\Settings\Terms
 */
class TermsRequest extends FormRequest implements IFormRequest
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
            'name'                      => 'required|min:3',
        ];
    }

    /**
     * @return array|
     */
    public function attributes()
    {
        return [
            'terms.quote'               => 'Quote terms',
            'terms.invoice'             => 'Invoice Terms',
            'metadata.deposit_required' => 'Deposit',
        ];
    }
}
