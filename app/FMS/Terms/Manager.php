<?php

namespace App\FMS\Terms;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\FMS\User\Models\User;

class Manager
{
    private $termsAndCondition;

    public function __construct(TermsAndCondition $termsAndCondition)
    {
        $this->termsAndCondition = $termsAndCondition;
    }

    public function findLatest(User $user)
    {
        return $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->join('tbl_terms_and_conditions', 'tbl_terms_and_conditions.site_id', 'sites.id')
            ->where('user_sites.user_id', $user->id)
            ->select(
                'tbl_terms_and_conditions.id as id'
            )
            ->orderBy('tbl_terms_and_conditions.updated_at', 'DESC')
            ->first();
    }
}
