<?php

namespace App\Domain\Admin\Requests\Booking;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BookingRequest
 * @package App\Domain\Admin\Requests\Booking
 */
class BookingRequest extends FormRequest implements IFormRequest
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
            'booking_type_id'               => 'numeric|required',
            'site_id'                       => 'numeric|required',
            'date'                          => 'date|required',
            'customer'                      => 'required',
        ];
    }
}
