<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Product\ProductVariant;
use App\StartUp\BaseClasses\Controller\AdminController;

class DisableAllocationProcess extends AdminController
{
    public function __invoke(ProductVariant $productVariant)
    {
        $stock = $productVariant->stock;

        if (!$stock->fill([
            'is_allocation_ongoing' => false,
            'ongoing_allocation_causer' => null,
            'ongoing_allocation_job_material_id' => null,
        ])
            ->save()) {
            return $this->sendError('Could not disable allocating stock.');
        }

        return $this->sendSuccessResponse([], 'Allocating Stock disabled.');
    }
}
