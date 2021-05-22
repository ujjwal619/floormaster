<?php

namespace App\FMS\Remittance\Actions;

use App\FMS\Remittance\Manager;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Remittance\Requests\CreateRequest;
use App\FMS\Remittance\ValueObjects\DefaultItemStatus;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateRemittanceItem extends AdminController
{
    public function __invoke(
        Remittance $remittance,
        RemittanceItem $remittanceItem, 
        Manager $remittanceManager, 
        Request $request
    ) {
        $request->validate([
            'default_item_status' => 'required|numeric|in:'. implode(',', [DefaultItemStatus::PAY, DefaultItemStatus::HOLD]),
        ]);

        if (!$remittanceItem = $remittanceManager->updateRemittanceItem(
            $remittanceItem, 
            $request->only(['default_item_status'])
        )) {
            abort('204', 'Could not update Remittance Item.');
        }

        return $this->sendSuccessResponse($remittanceItem->toArray(), 'Remittance Item updated successfully.');
    }
}
