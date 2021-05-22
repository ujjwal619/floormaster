<?php

namespace App\FMS\InstallationComplaint;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\User\Models\User;

class Manager
{
    use FilterSiteByUserTrait;

    public function findLatest(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->join('tbl_installation_complaints', 'tbl_installation_complaints.job_id', 'tbl_jobs.id')
            ->select(
                'tbl_installation_complaints.id as id',
                'tbl_installation_complaints.job_id as job_id',
                'tbl_installation_complaints.project as project',
                'tbl_installation_complaints.received_by as received_by',
                'tbl_installation_complaints.referred_to as referred_to',
                'tbl_installation_complaints.sales_person as sales_person',
                'tbl_installation_complaints.complaint as complaint',
                'tbl_installation_complaints.action as action',
                'tbl_installation_complaints.date_received as date_received',
                'tbl_installation_complaints.date_rectified as date_rectified',
                'tbl_installation_complaints.created_by_id as created_by_id'
            )
            ->orderBy('tbl_installation_complaints.updated_at', 'DESC')
            ->first();
    }
}
