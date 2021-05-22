<?php

namespace App\FMS\Terms\Actions;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListTermsBySite extends AdminController
{
    public function __invoke(Site $site, Request $request, TermsAndCondition $termsAndCondition)
    {
        $listTerms = $termsAndCondition->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($listTerms);
    }
}
