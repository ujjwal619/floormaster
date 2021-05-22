<?php

namespace App\FMS\Site;

use App\FMS\Site\Models\Site;
use App\FMS\User\Models\User;

class Manager
{
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function isUserSite(User $user, int $siteId)
    {
        $sites = $user->getSiteIds();

        return $sites->contains($siteId);
    }

    public function create(array $details)
    {
        // if ($this->site->count() >= 4) {
        //     abort(403, 'Site Creation Limit Reached.');
        // }
        $site = $this->site->create($details);

        // $this->save($this->site->newInstance(), $details);
        return $site;
    }

    public function all()
    {
        return $this->site->all();
    }

    public function update(Site $site, array $details)
    {
        return $this->save($site, $details);
    }

    public function save(Site $site, array $details)
    {
        return $site->fill($details)->save();
    }
}
