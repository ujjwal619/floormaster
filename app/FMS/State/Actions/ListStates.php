<?php

namespace App\FMS\State\Actions;

use App\StartUp\BaseClasses\Controller\AdminController;

class ListStates extends AdminController
{
    public function __invoke()
    {
        return $this->sendSuccessResponse(config('states'));
    }
}
