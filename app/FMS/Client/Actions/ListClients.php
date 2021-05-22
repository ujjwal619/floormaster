<?php

namespace App\FMS\Client\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListClients extends AdminController
{
    use FilterSiteByUserTrait;

    public function __construct()
    {
        $this->middleware(['permission:client.access']);
    }
    
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $site = $request->get('site_id');

        $data = $this->filterSiteByUser($user)
            ->join('tbl_customers', 'tbl_customers.site_id', 'sites.id')
            ->select(
                'tbl_customers.id as id',
                'tbl_customers.trading_name as trading_name',
                'tbl_customers.created_at as created_at'
            );

        if ($site) {
            $data = $data->where('tbl_customers.site_id', $site);
        }

        $data = $data
            ->latest()
            // ->groupBy('tbl_future_stocks.id')
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
