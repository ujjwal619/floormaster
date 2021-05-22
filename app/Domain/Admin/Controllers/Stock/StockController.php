<?php

namespace App\Domain\Admin\Controllers\Stock;

use App\Data\Entities\Models\Product\ProductVariant;
use App\Domain\Admin\Requests\Stock\CurrentStockRequest;
use App\Domain\Admin\Requests\Stock\FutureStockRequest;
use App\Domain\Admin\Requests\Stock\UpdateCurrentStockRequest;
use App\Domain\Admin\Requests\Stock\UpdateFutureStockRequest;
use App\Domain\Admin\Services\Product\ProductService;
use App\Domain\Admin\Services\Product\ProductVariantService;
use App\Domain\Admin\Services\Stock\StockService;
use App\Domain\Admin\Services\Supplier\SupplierService;
use App\FMS\Color\Manager;
use App\FMS\Stock\Manager as StockManager;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\BackOrder;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends AdminController
{
    private $productService;

    private $supplierService;

    private $service;

    private $productVariantService;

    private $selectListHelper;

    private $stockManager;

    private $colorManager;

    public function __construct(
        ProductService $productService,
        SupplierService $supplierService,
        StockService $service,
        ProductVariantService $productVariantService,
        SelectListHelper $selectListHelper,
        StockManager $stockManager,
        Manager $colorManager
    ) {
        $this->productService = $productService;
        $this->supplierService = $supplierService;
        $this->service = $service;
        $this->productVariantService = $productVariantService;
        $this->selectListHelper = $selectListHelper;
        $this->stockManager = $stockManager;
        $this->colorManager = $colorManager;
    }

    public function redirect(Request $request)
    {
        $latestProductVariant = $this->stockManager->findLatest($request->user());

        throw_if(!$latestProductVariant, new ModelNotFoundException('Could not find Product.'));

        return redirect(route('admin.stocks.edit', ['colorId' => $latestProductVariant->id]));
    }

    public function edit(ProductVariant $productVariant, Request $request)
    {
        $stock = $this->stockManager->findStockByColor($productVariant->id);

        if (!$stock) {
            $this->service->store($productVariant, []);
        }

        $color = $this->colorManager->findProductVariant($productVariant->id);
        $color->allocations = $color->allocations->map(function (Allocation $allocation) {
            return $allocation->load('currentStock', 'job');
        });

        $color->backOrders = $color->backOrders->map(function (BackOrder $backOrder) {
            return $backOrder->load('futureStock', 'job');
        });

        $stock = $color->stock;
        $stock->load('ongoingAllocationCauser', 'ongoingAllocationJobMaterialSale');
        $stock->is_allocation_ongoing =  $request->user()->id === $color->stock->ongoing_allocation_causer ? true : false;
        $product = $color->product;
        $supplier = $product->supplier;
        $currentStocks = $color->currentStocks->groupBy('batch')->toArray();
        $futureStocks = $color->futureStocks->toArray();
        $products = $this->selectListHelper->getAllProducts();

        return view('admin.modules.stock.index', [
            'color' => $color,
            'product' => $product,
            'supplier' => $supplier,
            'currentStocks' => $currentStocks,
            'stock' => $stock,
            'futureStocks' => $futureStocks,
            'products' => $products
        ]);
    }

    public function store(int $colorId, Request $request)
    {
        return $this->service->store($this->productVariantService->find($colorId), $request->all());
    }

    public function storeCurrentStocks(int $colorId, CurrentStockRequest $request)
    {
        try {
            $productVariant = $this->productVariantService->find($colorId);

            $this->service->storeCurrentStocks($productVariant, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new current stock.', 'error');

            return $this->sendError('Unable to create new current stock.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new current stock.');
    }

    public function updateCurrentStock(int $colorId, int $currentStockId, UpdateCurrentStockRequest $request)
    {
        try {
            $this->service->updateCurrentStock($currentStockId, $request->all());
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);
            flash('Unable to update current stock.', 'error');

            return $this->sendError('Unable to update current stock.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated current stock.');
    }

    public function storeFutureStocks(int $colorId, FutureStockRequest $request)
    {
        try {
            $productVariant = $this->productVariantService->find($colorId);

            $this->service->storeFutureStocks($productVariant, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new current stock.', 'error');

            return $this->sendError('Unable to create new current stock.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new future stock.');
    }

    public function updateFutureStock(int $futureStockId, UpdateFutureStockRequest $request)
    {
        try {
            $this->service->updateFutureStock($futureStockId, $request->all());
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);
            flash('Unable to create new future stock.', 'error');

            return $this->sendError('Unable to create new future stock.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new future stock.');
    }

    public function createOrderReceipt(int $futureStockId, Request $request)
    {
        $request->validate([
            'size' => 'numeric|required',
            'delivery_date' => 'date|required',
            'batch' => 'required',
            'roll_no' => 'required',
        ]);

        try {
            throw_if(
                !$currentStock = $this->service->createOrderReceipt($futureStockId, $request->all()), 
                new \Exception('Purchase order receipt not created.')
            );
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new purchase order receipt.', 'error');

            return $this->sendError('Unable to create new purchase order receipt.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($currentStock->toArray(), 'Successfully created new purchase order receipt.');
    }

    public function createDeliveryOrders(int $futureStockId, Request $request)
    {
//        try {
//            $this->service->createDeliveryOrders($futureStockId, $request->all());
//        } catch (\Exception $exception) {
//            dd($exception);
//            logger()->error($exception);
//            flash('Unable to create new delivery orders.', 'error');
//
//            return $this->sendError('Unable to create new delivery orders.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
//        }

        return $this->sendSuccessResponse([], 'Successfully created new delivery orders.');
    }

    public function deleteFutureStock(int $id)
    {
        try {
            $this->service->deleteFutureStock($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Booking not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Booking.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully deleted booking.');
    }
}
