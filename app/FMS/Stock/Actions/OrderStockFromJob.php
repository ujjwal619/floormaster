<?php

namespace App\FMS\Stock\Actions;

use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Domain\Admin\Requests\Stock\FutureStockRequest;
use App\Domain\Admin\Services\Stock\StockService;
use App\StartUp\BaseClasses\Controller\AdminController;

class OrderStockFromJob extends AdminController
{
    public function __invoke(
        ProductVariant $productVariant,
        JobMaterialSale $jobMaterialSale,
        FutureStockRequest $request,
        StockService $stockService
    ) {
        $request->validate([
            'futureStocks.*.job_material_id' => 'required|numeric',
        ]);

        $productVariant->load(['product.supplier']);

        if (
            !$stockService->storeFutureStocks(
                $productVariant, 
                $request->all(),
                $jobMaterialSale->job_id
            )
        ) {
            return $this->sendError('Could not order stock.');
        }

        return $this->sendSuccessResponse([],'Successfully ordered stock.');
    }
}
