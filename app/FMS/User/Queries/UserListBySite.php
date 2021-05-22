<?php

namespace App\FMS\User\Queries;

use App\FMS\Site\Models\Site;

class UserListBySite
{
    public function fetch(Site $site)
    {
        return $site->users;
    }
}
