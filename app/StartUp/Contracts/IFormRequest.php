<?php

namespace App\StartUp\Contracts;

/**
 * Interface IFormRequest
 * @package App\StartUp\Contracts
 */
interface IFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages();
}
