<?php

namespace App\FMS\Site\Traits;

use App\FMS\User\Models\User;

trait FilterSiteByUserTrait
{
    public function filterSiteByUser(User $user)
    {
        return $user->newQuery()
        ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
        ->join('sites', 'sites.id', 'user_sites.site_id')
        ->where('user_sites.user_id', $user->id);
    }
}
