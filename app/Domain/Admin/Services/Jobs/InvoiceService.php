<?php

namespace App\Domain\Admin\Services\Jobs;

use App\Data\Repositories\Job\InvoiceRepository;

class InvoiceService
{
    private $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }
}
