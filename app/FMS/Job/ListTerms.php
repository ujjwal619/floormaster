<?php

namespace App\FMS\Job;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListTerms extends AdminController
{
    public function __invoke(TermsAndCondition $termsAndCondition)
    {
        $temrs = $termsAndCondition->newQuery()->get();
        return $this->sendSuccessResponse($temrs->toArray());
    }
}
