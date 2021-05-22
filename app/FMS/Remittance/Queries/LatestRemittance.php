<?php

namespace App\FMS\Remittance\Queries;

use App\FMS\User\Models\User;

class LatestRemittance
{
    public function fetch(User $user)
    {
        return $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->where('user_sites.user_id', $user->id)
            ->join('remittances', 'remittances.site_id', 'sites.id')
            ->where('remittances.is_paid', true)
            ->select(
                'remittances.id as id'
            )
            ->orderBy('remittances.updated_at', 'DESC')
            ->first();
    }
}
