<?php

namespace App\FMS\Stock;

use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\FutureStock;
use App\Data\Entities\Models\Stock\Stock;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\Stock\Events\CalculateStockTotal;
use App\FMS\User\Models\User;
use Illuminate\Database\DatabaseManager;

class Manager
{
    use FilterSiteByUserTrait;

    private $stock;

    private $databaseManager;

    private $jobManager;

    private $currentStock;

    public function __construct(
        Stock $stock, 
        DatabaseManager $databaseManager, 
        \App\FMS\Job\Manager $jobManager,
        CurrentStock $currentStock
    ) {
        $this->stock = $stock;
        $this->databaseManager = $databaseManager;
        $this->jobManager = $jobManager;
        $this->currentStock = $currentStock;
    }

    public function findLatest(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_product_variants', 'tbl_product_variants.site_id', 'sites.id')
            ->select('tbl_product_variants.id as id')
            ->orderBy('tbl_product_variants.updated_at', 'DESC')
            ->first();
    }

    public function findStockByColor(int $colorId)
    {
        return $this->stock->newQuery()->where(['variant_id' => $colorId])->with(['ongoingAllocationJobMaterialSale'])->first();
    }

    public function allocateFutureStock(
        FutureStock $futureStock, 
        array $details, 
        $jobMaterial = NULL, 
        $isFromCustomerOrder = false
    ) {
        return $this->databaseManager->transaction(function () use (
            $details,
            $futureStock,   
            $jobMaterial,
            $isFromCustomerOrder
        ) {
            try {
                $soldAmount = $futureStock->sold + array_get($details, 'amount');
                $futureStock->load('color');
                $color = $futureStock->color;
                $futureStock->fill(['sold' => $soldAmount])->save();

                if (
                    array_get($details, 'job_id') &&
                    $job = $this->jobManager->find(array_get($details, 'job_id'))
                ) {

                    if (
                        array_get($details, 'job_material_id') &&
                        $jobMaterial = $this->jobManager->findJobMaterialById(array_get($details, 'job_material_id'))
                    ) {
                        $allocatedTotal = $jobMaterial->allocated + array_get($details, 'amount');
                        $jobMaterial->fill([
                            'allocated' => $allocatedTotal,
                            'on_order' => $jobMaterial->on_order + array_get($details, 'on_order', 0),
                            'act_on' => $jobMaterial->quantity - $allocatedTotal
                        ])->save();
                    }

                    $details['client'] = $job->trading_name;
                    $details['project'] = $job->project;
                }

                $details['variant_id'] = $futureStock->color->id;
                $details['site_id'] = $futureStock->site_id;
                $backOrder = $futureStock->backOrders()->create($details);

                if ($isFromCustomerOrder) {
                    $futureStock->fill(['back_order_id' => $backOrder->id])->save();
                }

                event(new CalculateStockTotal($color));
                $this->databaseManager->commit();

                return true;
            } catch (\Exception $exception) {
                $this->databaseManager->rollBack();
                dd($exception);

                return false;
            }
        });
    }

    public function findCurrentStock(int $id)
    {
        return $this->currentStock->find($id);
    }

    public function createCurrentStock(ProductVariant $productVariant, array $details)
    {
        $details['quantity'] = $details['size'];
        $currentStock = $productVariant->currentStocks()->create($details);
        return $currentStock;
    }

    public function createFutureStockReceiveGroup(FutureStock $futureStock, array $details = [])
    {
        return $futureStock->receiveGroups()->create($details);
    }

    public function calculateFutureStockPrice(array $details, string $result = 'total')
    {
        $price = (array_get($details, 'quantity') * array_get($details, 'list_price'));
        $discountAmount = ($price * array_get($details, 'discount')) / 100;
        $discountedPrice = $price - $discountAmount;
        $levyAmount = ($discountedPrice * array_get($details, 'levy', 0)) / 100;
        $afterLevy = $discountedPrice + $levyAmount;
        $deliveryAmount = array_get($details, 'delivery', 0);
        $afterDelivery = $afterLevy + $deliveryAmount;
        $taxAmount = ($afterDelivery * array_get($details, 'tax', 0)) / 100;
        $afterTax = number_format($afterDelivery + $taxAmount, 2, '.', '');
        
        if ($result == 'goods') {
            return $afterTax - number_format($levyAmount, 2, '.', '') - $deliveryAmount - number_format($taxAmount, 2, '.', '');
        }

        return $afterTax;
    }
}
