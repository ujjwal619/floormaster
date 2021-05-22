<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Models\CashBook;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use DateTime;
use Illuminate\Http\Request;

class ListBankReconciliationBySite extends AdminController
{
    public function __invoke(Site $site, Request $request, CashBook $cashBook)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $data = $cashBook->newQuery()
            ->with(['account', 'job', 'remittance', 'receipt'])
            ->where('site_id', $site->id)
            // ->whereBetween('date', [$from, $to])
            ->whereNull('presented_date')
            ->latest()
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
