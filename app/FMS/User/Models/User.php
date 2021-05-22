<?php

namespace App\FMS\User\Models;

use App\Constants\DBTable;
use App\Data\Entities\Traits\UuidTrait;
use App\FMS\Core\Interfaces\HasMorphInterface;
use App\FMS\Core\Traits\GetMorphAlias;
use App\FMS\Site\Models\Site;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMorphInterface
{
    use Notifiable, UuidTrait, HasRoles, GetMorphAlias;

    protected $table = DBTable::AUTH_USERS;

    const MORPH_ALIAS = 'user';

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = app('hash')->needsRehash($password) ? Hash::make($password) : $password;
    }

    public function sites()
    {
        $sites = $this->belongsToMany(
            Site::class, 
            DBTable::USER_SITES, 
            'user_id', 
            'site_id'
        );
        
        if ($this->isSuperAdmin()) {
            $site = app(Site::class);
            $sites = $sites->orWhereIn('site_id', $site->all()->pluck('id')->toArray());
        }

        return $sites;
    }

    public function sharedSites()
    {
        $sites = $this->getSiteIds();

        if ($sites->contains(3) || $sites->contains(4)) {
            return $this->belongsToMany(
                Site::class, 
                DBTable::USER_SITES, 
                'user_id', 
                'site_id'
            )->orWhereIn('sites.id', [3,4])->distinct('sites.id');
        }

        return $this->sites();
    }

    public function getSiteIds()
    {
        return $this->sites->pluck('id');
    }

    public function getSharedSiteIds()
    {
        return $this->sharedSites->unique()->pluck('id');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }
}
