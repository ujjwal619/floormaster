<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Stock\FutureStock;
use App\StartUp\BaseClasses\Controller\AdminController;

class ShowFutureStock extends AdminController
{
    public function __invoke(FutureStock $futureStock)
    {
        return $this->sendSuccessResponse($futureStock->toArray(), 'Successfully created marry invoice.');
    }
}
