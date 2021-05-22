<?php

namespace App\FMS\Supplier\Queries;

use App\FMS\Filters\AdvanceQueryFilter;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;

class SupplierReport
{
    use FilterSiteByUserTrait;

    public function run(Request $request)
    {
        return $this->getFilteredSuppliers($request)
            ->paginate($request->get('per_page', config('fms.paginationLimit')));
    }

    public function export(Request $request)
    {
        return $this->getFilteredSuppliers($request)
            ->get();
    }

    private function getFilteredSuppliers(Request $request)
    {
        $user = $request->user();

        return $this->filterSiteByUser($user)
            ->join('tbl_suppliers', 'tbl_suppliers.site_id', 'sites.id')
            ->select(
                'tbl_suppliers.id as id',
                'tbl_suppliers.trading_name as trading_name',
                new Expression('
                    CONCAT(tbl_suppliers.street, ", ", tbl_suppliers.suburb, ", ", tbl_suppliers.state, ", ", tbl_suppliers.code) as address
                '),
                'tbl_suppliers.contact as contact',
                'sites.name as site_name'
            )
            ->filter($this->getFilter());
    }

    private function getFilter()
    {
        // @var AdvanceQueryFilter
        $filter = app(AdvanceQueryFilter::class);

        $filter->setFilterableColumns($this->getFilterableColumns())
            ->setSortableColumns(['id', 'trading_name', 'site_name']);

        return $filter;
    }

    private function getFilterableColumns()
    {
        return [
            'where' => [
                'id' => 'tbl_suppliers.id',
                'trading_name' => 'tbl_suppliers.trading_name', 
                'site_name' => 'sites.name',               
            ],
            'having' => [
            ],
        ];
    }   
}