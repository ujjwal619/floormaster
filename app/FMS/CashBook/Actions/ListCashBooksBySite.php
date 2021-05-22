<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Models\CashBook;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use DateTime;
use Illuminate\Http\Request;

class ListCashBooksBySite extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:cash.book']);
    }

    public function __invoke(Site $site, Request $request, CashBook $cashBook)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $data = $cashBook->newQuery()
            ->with(['account', 'job', 'remittance', 'receipt', 'site.chequeAccount'])
            ->where('site_id', $site->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->latest()
            ->get();

        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F'); // March

        $data['meta'] = [
            'month' => $month,
            'month_name' => $monthName,
            'year' => $year
        ];

        return $this->sendSuccessResponse($data->toArray());
    }
}
