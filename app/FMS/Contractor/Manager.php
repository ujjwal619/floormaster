<?php

namespace App\FMS\Contractor;

use App\Data\Entities\Models\Contractor\Contractor;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\User\Models\User;

class Manager
{
    use FilterSiteByUserTrait;

    private $contractor;

    public function __construct(Contractor $contractor)
    {
        $this->contractor = $contractor;
    }

    public function find(int $id)
    {
        return $this->contractor->with(['payments.job.customer'])->find($id);
    }

    public function findLatest(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_contractors', 'tbl_contractors.site_id', 'sites.id')
            ->select(
                'tbl_contractors.id as id'
            )
            ->orderBy('tbl_contractors.updated_at', 'DESC')
            ->first();
    }

    public function findPrevious(User $user, int $contractorId)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_contractors', 'tbl_contractors.site_id', 'sites.id')
            ->where('tbl_contractors.id', '<', $contractorId)
            ->select(
                'tbl_contractors.id as id'
            )
            ->max('tbl_contractors.id');
    }

    public function findNext(User $user, int $contractorId)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_contractors', 'tbl_contractors.site_id', 'sites.id')
            ->where('tbl_contractors.id', '>', $contractorId)
            ->select(
                'tbl_contractors.id as id'
            )
            ->min('tbl_contractors.id');
    }
}
