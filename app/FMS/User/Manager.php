<?php

namespace App\FMS\User;

use App\FMS\Site\Manager as SiteManager;
use App\FMS\User\Models\User;
use Illuminate\Database\DatabaseManager;

class Manager
{
    private $user;
    private $databaseManager;
    private $siteManager;

    public function __construct(DatabaseManager $databaseManager, User $user, SiteManager $siteManager)
    {
        $this->user = $user;
        $this->databaseManager = $databaseManager;
        $this->siteManager = $siteManager;
    }

    public function create(array $details)
    {
        try {
            $this->databaseManager->beginTransaction();
            $user = $this->user->newInstance()->create($details);
            $user->sites()->sync(array_get($details, 'sites'));
            $this->databaseManager->commit();
            return $user;
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
        }

        return false;
    }

    public function update(User $user, array $details, User $currentUser)
    {
        try {
            $this->databaseManager->beginTransaction();
            $user->fill($details)->save();
            $isCurrentUserSuperUser = $currentUser->hasRole('super_admin');
            if ($sites = array_get($details, 'sites')) {
                $user->sites()->sync($sites);
            }
            if ($permissions = array_get($details, 'permissions')) {
                $user->syncPermissions($permissions);
            }
            if (
                $isCurrentUserSuperUser &&
                $currentUser->id !== $user->id
            ) {
                if (array_get($details, 'is_super_admin')) {
                    $user->assignRole('super_admin');
                    $user->sites()->sync($this->siteManager->all());
                } else {
                    $user->removeRole('super_admin');   
                }
            }
            $this->databaseManager->commit();
            return $user;
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
        }

        return false;
    }

    public function find(string $id)
    {
        return $this->user->where('id', $id)->first();
    }
}
