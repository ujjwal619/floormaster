<?php

namespace App\Domain\Admin\Services\Account;

use App\Data\Repositories\Account\AccountRepository;

class AccountService
{
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $details)
    {
        $details['total_balance'] = $details['opening_balance'];
        return $this->repository->create($details);
    }

    public function getByFamily(int $familyId, int $siteId)
    {
        return $this->repository->getByFamily($familyId, $siteId);
    }

    public function update(int $id, array $details)
    {
        $details['total_balance'] = $details['opening_balance'] + $details['account_balance'];
        return $this->repository->update($details, $id);
    }
}
