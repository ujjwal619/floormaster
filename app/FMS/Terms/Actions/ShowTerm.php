<?php

namespace App\FMS\Terms\Actions;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowTerm extends AdminController
{
    public function __construct(TermsAndCondition $termsAndCondition)
    {
        dd($termsAndCondition);
    }
}
