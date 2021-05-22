<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Manager;
use App\FMS\Remittance\Queries\LatestRemittance;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexRemittance extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:cheque.butt']);
    }

    public function __invoke(Request $request, LatestRemittance $latestRemittance, Manager $remittanceManager)
    {
        $remittance = $latestRemittance->fetch($request->user());

        if (!$remittance) {
            return new JsonResponse(['success' => 'true', 'data' => [], 'message' => 'No Records.']);
        }

        return $this->sendSuccessResponse($remittanceManager->find($remittance['id'])->toArray());
    }
}
