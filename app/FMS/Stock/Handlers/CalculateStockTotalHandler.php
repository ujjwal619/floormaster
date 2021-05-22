<?php

namespace App\FMS\Stock\Handlers;

use App\FMS\Stock\Events\CalculateStockTotal;

class CalculateStockTotalHandler
{

    public function __construct(
        
    ) {
          
    }

    public function handle(CalculateStockTotal $calculateStockTotal)
    {
        $color = $calculateStockTotal->color();

        $stock = $color->stock;

        $currentStocks = $color->currentStocks;
        $futureStocks = $color->futureStocks;
        $allocations = $color->allocations;
        $backOrders = $color->backOrders;

        $currentStockForSell = $currentStocks->reduce(function($carry, $currentStock) {
            return $carry + ($currentStock->size - $currentStock->sold);
        });

        $futureStockForSell = $futureStocks->reduce(function($carry, $futureStock) {
            return $carry + (($futureStock->quantity - $futureStock->sold) > 0 ? 
            ($futureStock->quantity - $futureStock->received - $futureStock->sold) : 0 ) ;
        });

        $totalAllocations = $allocations->reduce(function($carry, $allocation) {
            return $carry + $allocation->amount;
        });

        $totalBackOrders = $backOrders->reduce(function($carry, $backOrder) {
            return $carry + $backOrder->amount;
        });

        $totalCurrentStock = $currentStocks->reduce(function($carry, $currentStock) {
            return $carry + $currentStock->size;
        });

        $totalFutureStock = $futureStocks->reduce(function($carry, $futureStock) {
            return $carry + ($futureStock->quantity - $futureStock->received);
        });

        if ($stock) {
            $stock->fill([
                'current_stock_total_for_sell' => $currentStockForSell,
                'future_stock_total_for_sell' => $futureStockForSell,
                'total_allocations' => $totalAllocations,
                'total_back_orders' => $totalBackOrders,
                'total_current_stock' => $totalCurrentStock,
                'total_future_stock' => $totalFutureStock
            ])->save();
        }
    }
}
