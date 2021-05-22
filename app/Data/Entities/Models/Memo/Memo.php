<?php

namespace App\Data\Entities\Models\Memo;


use App\Constants\DBTable;
use App\Data\Entities\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Memo
 * @package App\Data\Entities\Models\Memo
 */
class Memo extends Model
{
    /**
     * @var string
     */
    protected $table = DBTable::MEMOS;

    /**
     * Guard the following fields.
     * @var array
     */
    protected $fillable = [
        'subject', 
        'details', 
        'date', 
        'user_id', 
        'time', 
        'reference_type', 
        'reference_id',
        'further_action',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning reference models.
     */
    public function reference()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getFormattedDateTimeAttribute(): string
    {
        $date = Carbon::parse($this->date)->format('d M Y');
        $time = Carbon::parse($this->time)->format('h:i A');

        return sprintf('%s %s', $date, $time);
    }
}