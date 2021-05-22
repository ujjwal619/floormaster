<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Product\ProductVariant;
use App\Domain\Admin\Services\Stock\StockService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class EnableAllocationProcess extends AdminController
{
    public function __invoke(ProductVariant $productVariant, Request $request, StockService $stockService)
    {
        $request->validate([
            'job_material_id' => 'required|numeric'
        ]);

        $stock = $productVariant->stock ?? $stockService->store($productVariant, []);

        if (!$stock->fill([
            'is_allocation_ongoing' => true,
            'ongoing_allocation_causer' => $request->user()->id,
            'ongoing_allocation_job_material_id' => $request->all()['job_material_id'],
        ])
            ->save()) {
            return $this->sendError('Could not allocate stock.');
        }

        return $this->sendSuccessResponse([], 'Allocating Stock.');
    }
}
