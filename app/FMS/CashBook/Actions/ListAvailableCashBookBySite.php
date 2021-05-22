<?php

namespace App\FMS\CashBook\Actions;

use App\FMS\CashBook\Models\CashBook;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListAvailableCashBookBySite extends AdminController
{
    public function __invoke(Site $site, CashBook $cashBook)
    {
        $data = $cashBook->newQuery()
            ->where('site_id', $site->id)
            ->selectRaw("
            DATE_FORMAT(cash_books.date, '%c') as month, 
            DATE_FORMAT(cash_books.date, '%M') as month_name, 
            DATE_FORMAT(cash_books.date, '%Y') as year
            ")
            ->distinct('month')
            ->get();

        return $this->sendSuccessResponse($data->toArray());
    }
}
