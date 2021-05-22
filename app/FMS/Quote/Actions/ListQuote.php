<?php

namespace App\FMS\Quote\Actions;

use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListQuote extends AdminController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return $this->sendSuccessResponse(
            $user->newQuery()
                ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
                ->join('sites', 'sites.id', 'user_sites.site_id')
                ->join('tbl_quotes', 'tbl_quotes.site_id', 'sites.id')
                ->where('user_sites.user_id', $user->id)
                ->where('tbl_quotes.converted_to_job', 0)
                ->select(
                    'tbl_quotes.id as id',
                    'tbl_quotes.quote_id as quote_id'
                )
                ->get()
                ->toArray()
        );
    }
}
