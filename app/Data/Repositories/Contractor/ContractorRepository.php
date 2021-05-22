<?php

namespace App\Data\Repositories\Contractor;

use App\Data\Entities\Models\Contractor\Contractor;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ContractorRepository extends RepositoryInterface
{
    public function getLatest(): Contractor;
}
