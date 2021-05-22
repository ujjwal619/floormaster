<?php

namespace App\Data\Entities\Models\Booking;

use App\Constants\DBTable;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingType
 * @package App\Data\Entities\Models\Booking
 */
class BookingType extends Model
{
    use ModelTrait;

    /**
     * @var string
     */
    protected $table = DBTable::BOOKING_TYPES;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 
        'numeric_column_headings', 
        'default_day_limit', 
        'text_column_heading',
        'site_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'numeric_column_headings' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
