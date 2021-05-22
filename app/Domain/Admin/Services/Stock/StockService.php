<?php

namespace App\Domain\Admin\Services\Stock;

use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Repositories\Stock\CurrentOrderRepository;
use App\Data\Repositories\Stock\CurrentStockRepository;
use App\Data\Repositories\Stock\FutureStockRepository;
use App\Data\Repositories\Stock\OrderReceiptRepository;
use App\Data\Repositories\Stock\StockRepository;
use App\FMS\Job\Manager as JobManager;
use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\Stock\Events\FutureStockReceived;
use App\FMS\Stock\Manager as StockManager;
use Exception;
use Illuminate\Database\DatabaseManager;

class StockService
{
    private $repository;

    private $currentStockRepository;

    private $databaseManager;

    private $currentOrderRepository;

    private $futureStockRepository;

    private $orderReceiptRepository;

    private $jobManager;

    private $stockManager;

    public function __construct(
        StockRepository $repository,
        CurrentStockRepository $currentStockRepository,
        DatabaseManager $databaseManager,
        CurrentOrderRepository $currentOrderRepository,
        FutureStockRepository $futureStockRepository,
        OrderReceiptRepository $orderReceiptRepository,
        JobManager $jobManager,
        StockManager $stockManager
    )
    {
        $this->repository = $repository;
        $this->currentStockRepository = $currentStockRepository;
        $this->databaseManager = $databaseManager;
        $this->currentOrderRepository = $currentOrderRepository;
        $this->futureStockRepository = $futureStockRepository;
        $this->orderReceiptRepository = $orderReceiptRepository;
        $this->jobManager = $jobManager;
        $this->stockManager = $stockManager;
    }

    public function store(ProductVariant $productVariant, array $details)
    {
        $details['site_id'] = $productVariant->site_id;
        return $productVariant->stock()->updateOrCreate(['variant_id' => $productVariant->id], $details);
    }

    public function storeCurrentStocks(ProductVariant $productVariant, array $details)
    {
        $this->databaseManager->transaction(function () use (
            $productVariant, 
            $details
        ) {
            try {
                $productVariant->currentStocks()->createMany($details);

                event(new CalculateStockTotal($productVariant));
                $this->databaseManager->commit();
            } catch (\Exception $exception) {
                $this->databaseManager->rollBack();
                return false;
            }
        });
        return true;
    }

    public function updateCurrentStock(int $currentStockId, array $details)
    {
        $this->databaseManager->transaction(function () use ($currentStockId, $details) {
            try {
                $currentStock = $this->findCurrentStock($currentStockId);
                $productVariant = $currentStock->color;
                $this->currentStockRepository->update($details, $currentStockId);
                event(new CalculateStockTotal($productVariant));
                $this->databaseManager->commit();
            } catch (\Exception $exception) {
                $this->databaseManager->rollBack();
                return false;
            }
        });

        return true;
    }

    public function updateFutureStock(int $futureStockId, array $details)
    {
        $this->databaseManager->transaction(function () use ($futureStockId, $details) {
            try {
                $filteredDetails = [
                    'quantity' => array_get($details, 'quantity'),
                    'unit' => array_get($details, 'unit'),
                    'list_price' => array_get($details, 'list_price'),
                    'discount' => array_get($details, 'discount', 0),
                    'tax' => array_get($details, 'tax'),
                    'levy' => array_get($details, 'levy', 0) ?? 0,
                    'delivery' => array_get($details, 'delivery'),
                    'delivery_date' => array_get($details, 'delivery_date'),
                ];

                $costedPrice = $this->calculateCostedPrice([$filteredDetails]);
                $filteredDetails['total_cost'] = $costedPrice;

                $futureStock = $this->findFutureStock($futureStockId);
                if($jobMaterial = $futureStock->jobMaterial) {
                    $onOrderDifference = $filteredDetails['quantity'] - $futureStock->quantity;
                    $jobMaterial->fill(['on_order' => $jobMaterial->on_order + $onOrderDifference])->save();
                }
                $currentOrder = $futureStock->currentOrder;
                $newCostedPrice = $currentOrder->costed_price - $futureStock->total_cost + $costedPrice;
                $currentOrder->fill(['costed_price' => $newCostedPrice])->save();
                $this->futureStockRepository->update($filteredDetails, $futureStockId);
                $productVariant = $futureStock->color;
                if ($productVariant) {
                    event(new CalculateStockTotal($productVariant));
                }

                $this->databaseManager->commit();
            } catch (\Exception $exception) {
                $this->databaseManager->rollBack();
                return false;
            }

            return true;
        });
    }

    public function calculateCostedPrice(array $futureStocks = [])
    {
        return collect($futureStocks)->reduce(function ($carry, $stock) {
            $price = (array_get($stock, 'quantity') * array_get($stock, 'list_price'));
            $discountedPrice = $price - (($price * array_get($stock, 'discount')) / 100);
            $afterLevy = $discountedPrice + (($discountedPrice * array_get($stock, 'levy', 0)) / 100);
            $afterDelivery = $afterLevy + array_get($stock, 'delivery', 0);
            $afterTax = $afterDelivery + (($afterDelivery * array_get($stock, 'tax', 0)) / 100);
            $stockSum = $afterTax;

            return $carry + $stockSum;
        });
    }

    public function storeFutureStocks(ProductVariant $productVariant, array $details, int $jobId = null)
    {
        $this->databaseManager->transaction(function () use ($productVariant, $details, $jobId) {
            try {
                $dueDate = collect($details['futureStocks'])->max('delivery_date');

                $totalSize = collect($details['futureStocks'])->reduce(function ($carry, $currentStock) {
                    return $currentStock['quantity'] + $carry;
                });

                $costedPrice = $this->calculateCostedPrice($details['futureStocks']);

                $stock = $productVariant->stock ?? $this->store($productVariant, []);

                $stock->fill([
                    'future_stock_total_for_sell' => $totalSize + $stock->future_stock_total_for_sell,
                    'total_future_stock' => $totalSize + $stock->total_future_stock
                ])->save();

                $supplier = $productVariant->product->supplier;

                $currentOrderData = [
                    'supplier_details' => [
                        'contact' => array_get($details, 'supplier_details.placed_with'),
                        'id' => $supplier->id,
                        'trading_name' => $supplier->trading_name,
                        'site_id' => $supplier->site_id,
                        'street' => $supplier->street,
                        'suburb' => $supplier->suburb,
                        'state' => $supplier->state,
                        'code' => $supplier->code,
                        'phone' => $supplier->phone,
                        'fax' => $supplier->fax,
                    ],
                    'delivery_address' => $details['delivery_address'],
                    'interim_order_number' => $details['interim_order_number'],
                    'supplier_reference' => $details['supplier_reference'],
                    'due_date' => $dueDate,
                    'costed_price' => $costedPrice,
                    'site_id' => $productVariant->site_id,
                    'job_id' => $jobId,
                ];

                $currentOrder = $this->currentOrderRepository->create($currentOrderData);

                foreach ($details['futureStocks'] as $index => $futureStock) {
                    $jobMaterialId = array_get($futureStock, 'job_material_id');
                    $totalCost = $this->calculateCostedPrice([$details['futureStocks'][$index]]);
                    $details['futureStocks'][$index]['order_number'] = $currentOrder->id;
                    $details['futureStocks'][$index]['invoiced'] = 0;
                    $details['futureStocks'][$index]['total_cost'] = $totalCost;
                    $details['futureStocks'][$index]['levy'] = $details['futureStocks'][$index]['levy'] ?? 0;
                    $details['futureStocks'][$index]['site_id'] = $productVariant->site_id;
                    $details['futureStocks'][$index]['job_id'] = $jobId;
                    $details['futureStocks'][$index]['job_material_id'] = $jobMaterialId;
                    $futureStock = $productVariant->futureStocks()->create($details['futureStocks'][$index]);
                    if ($jobMaterialId) {
                        $jobMaterial = $this->jobManager->findJobMaterialById($jobMaterialId);

                        $actOn = $jobMaterial->act_on ?? $jobMaterial->quantity - $jobMaterial->allocated;

                        $quantityToBeAllocated = $actOn <= $futureStock['quantity'] 
                            ? $actOn : $futureStock['quantity']; 

                        $allocationFutureStockData = [
                            'job_material_id' => $jobMaterial->id,
                            'amount' => $quantityToBeAllocated,
                            'job_id' => $jobMaterial->job_id,
                            'on_order' => $futureStock['quantity']
                        ];
                        $this->stockManager->allocateFutureStock(
                            $futureStock, 
                            $allocationFutureStockData,
                            $jobMaterial,
                            !!$jobId
                        );
                    }
                }
                
                $this->databaseManager->commit();
            } catch (\Exception $exception) {
                dd($exception);
                $this->databaseManager->rollBack();
            }
        });
        return true;
    }

    public function getCurrentStocks(ProductVariant $productVariant)
    {
        return $productVariant->currentStocks->groupBy('batch');
    }

    public function getFutureStocks(ProductVariant $productVariant)
    {
        return $productVariant->futureStocks;
    }

    public function createMarryInvoice(int $futureStockId, array $details)
    {
        dd($details);
    }

    public function createOrderReceipt(int $futureStockId, array $details)
    {
        
        return $this->databaseManager->transaction(function () use ($details, $futureStockId) {
            try {
                $receivedQuantity = $details['size'];
                $futureStock = $this->futureStockRepository->with([
                    'color.product.category', 
                    'color.product.supplier.site', 
                    'currentOrder', 
                    'backOrder',
                    'jobMaterial'
                    ])->find($futureStockId);
                    
                

                if ($jobMaterial = $futureStock->jobMaterial) {
                    $jobMaterial->fill([
                        'on_order' => $jobMaterial->on_order - $receivedQuantity
                    ])->save();
                }
                
                $backOrder = $futureStock->backOrder;
                $color = $futureStock->color;
                $product = $color->product;
                $currentOrder = $futureStock->currentOrder;
                $productCategory = $product->category;
                $supplier = $product->supplier;
                $details['future_stock_id'] = $futureStockId;
                $details['received_date'] = $details['delivery_date'];
                $details['sold'] = $futureStock->job_id ? $receivedQuantity : 0;
                $details['site_id'] = $futureStock->site_id;

                throw_if(
                    $futureStock->quantity - $futureStock->received - $receivedQuantity < 0, 
                    new \Exception('Nothing left to receive.')
                );

                if (!array_get($details, 'future_stock_receive_group_id')) {
                    $futureStockReceiveGroup = $this->stockManager->createFutureStockReceiveGroup($futureStock);
                    $details['future_stock_receive_group_id'] = $futureStockReceiveGroup->id;
                }

                throw_if(
                    !$currentStock = $this->stockManager->createCurrentStock($color, $details),
                    new Exception('Could not create current Stock.')
                );

                $currentOrder->fill([
                    'last_date_received' => $details['delivery_date']
                ])->save();

                if ($backOrder) {
                    $allocationData = [
                        'variant_id' => $backOrder->variant_id,
                        'client' => $backOrder->client,
                        'job_id' => $backOrder->job_id,
                        'date_required' => $backOrder->date_required,
                        'amount' => $receivedQuantity,
                        'notes' => $backOrder->notes,
                        'drop_off' => $backOrder->drop_off,
                        'job_material_id' => $backOrder->job_material_id,
                        'project' => $backOrder->project,
                        'site_id' => $backOrder->site_id,
                        'is_linked' => $backOrder->is_linked
                    ];

                    $currentStock->allocations()->create($allocationData);

                    $backOrder->fill(['amount' => $backOrder->amount - $receivedQuantity])->save();
                }

                $futureStock->fill([
                    'received' => $futureStock->received + $receivedQuantity
                ])->save();

                throw_if(!$productCategory, new Exception('Product category not selected'));
                
                event(new FutureStockReceived($currentStock, $productCategory, $supplier));

                event(new CalculateStockTotal($color));

                $this->databaseManager->commit();
                
                return $currentStock;
            } catch (\Exception $exception) {
                $this->databaseManager->rollBack(); 
                
                return false;
            }
        });
    }

    public function createDeliveryOrders(int $futureStockId, array $details)
    {
        $this->databaseManager->transaction(function () use ($details, $futureStockId) {
            try {
                $futureStock = $this->futureStockRepository->find($futureStockId);
                $deliveryOrder = $futureStock->orderReceipt()->create($details);

                $futureStock->fill([

                ])->save();

                $this->databaseManager->commit();
            } catch (\Exception $exception) {
                dd($exception);
                $this->databaseManager->rollBack();
            }
        });
    }

    public function deleteFutureStock(int $id)
    {
        return $this->futureStockRepository->delete($id);
    }

    public function findCurrentStock(int $id)
    {
        return $this->currentStockRepository->find($id);
    }

    public function findFutureStock(int $id)
    {
        return $this->futureStockRepository->with(['color.stock', 'currentOrder'])->find($id);
    }

    public function findStockByColor(int $colorId)
    {
        return $this->repository->findByField('variant_id', $colorId);
    }
}
