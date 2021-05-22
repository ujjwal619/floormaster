<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\FMS\Job\Manager as JobManager;
use App\FMS\Stock\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllocateFutureStock extends AdminController
{
    public function __invoke(
        FutureStock $futureStock,
        Request $request,
        Manager $manager, 
        JobManager $jobManager
    )
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $details = $request->all();

        if (!$manager->allocateFutureStock($futureStock, $details)) {
            return $this->sendError('Could not allocate future stock.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully allocated future stock.');
    }
}
