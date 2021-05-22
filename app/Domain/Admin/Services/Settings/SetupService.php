<?php

namespace App\Domain\Admin\Services\Settings;

use App\Data\Repositories\Settings\SetupRepository;

class SetupService
{
    private $repository;

    public function __construct(SetupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(array $details)
    {
        $setup = $this->get();
        return $setup ? $setup->update($details) : $this->repository->create($details);
    }

    public function get()
    {
        return $this->repository->first();
    }
}
