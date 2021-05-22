<?php

namespace App\Data\Entities\Models\InstallationComplaint;

use App\Constants\DBTable;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class InstallationComplaint extends Model
{
    use ModelTrait;

    /**
     * @var string
     */
    protected $table = DBTable::INSTALLATION_COMPLAINTS;

    /**
     * @var array
     */
    protected $fillable = [
        'project',
        'received_by',
        'referred_to',
        'date_received',
        'date_rectified',
        'job_id',
        'action',
        'complaint',
        'sales_person',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id')->with('customer');
    }
}
