<?php

namespace App\Data\Repositories\Account;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AccountRepository
 * @package App\Data\Repositories\Account
 */
interface AccountRepository extends RepositoryInterface
{
    public function getByFamily(int $familyId, int $siteId);
}
