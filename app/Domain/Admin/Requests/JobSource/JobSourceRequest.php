<?php

namespace App\Domain\Admin\Requests\JobSource;


use App\Constants\DBTable;
use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class JobSourceRequest
 * @package App\Domain\Admin\Requests\JobSource
 */
class JobSourceRequest extends FormRequest implements IFormRequest
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
            'title' => 'required',
        ];
    }
}
