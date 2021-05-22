<?php

namespace App\FMS\Quote\Actions;

use App\Data\Entities\Models\Quote\Quote;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListQuoteBySite extends AdminController
{
    public function __invoke(Site $site, Quote $quote)
    {
        $quotes = $quote->newQuery()
            ->where('converted_to_job', 0)
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($quotes);
    }
}
