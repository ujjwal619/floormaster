<?php

namespace App\Domain\Admin\Requests\Booking;

use App\StartUp\Contracts\IFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BookingTypeRequest
 * @package App\Domain\Admin\Requests\Booking
 */
class BookingTypeRequest extends FormRequest implements IFormRequest
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
        $bookingTypeId = request()->segment(2) ?? 0;

        return [
            'numeric_column_headings'   => 'required',
            'name'                      => 'required|min:3|unique:tbl_booking_types,name,'.$bookingTypeId,
            'default_day_limit'         => 'numeric',
            'text_column_heading'       => 'required',
            'site_id'       => 'required',
        ];
    }
}
