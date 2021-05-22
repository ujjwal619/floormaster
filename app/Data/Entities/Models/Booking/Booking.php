<?php

namespace App\Data\Entities\Models\Booking;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * @package App\Data\Entities\Models\Booking
 */
class Booking extends Model
{
    use ModelTrait;

    /**
     * @var string
     */
    protected $table = DBTable::BOOKINGS;

    /**
     * @var array
     */
    protected $fillable = [
        'date',
        'job_id',
        'customer',
        'location',
        'phone',
        'note',
        'for',
        'estimated_time_of_arrival',
        'estimated_time_on_site',
        'numeric_column_headings',
        'text_column_heading',
        'booking_type_id',
        'site_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'numeric_column_headings' => 'array',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }
}
