<?php

namespace App\Data\Repositories\Supplier;

use App\Data\Entities\Models\Supplier\SupplierSite;
use App\StartUp\BaseClasses\Repository\BaseRepository;

/**
 * Class SupplierSiteEloquentRepository
 * @package App\Data\Repositories\Customer
 */
class SupplierSiteEloquentRepository extends BaseRepository implements SupplierSiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SupplierSite::class;
    }
}
