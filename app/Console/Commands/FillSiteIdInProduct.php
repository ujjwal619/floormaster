<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Product\ProductVariant;
use App\Data\Entities\Models\Stock\FutureStock;
use Illuminate\Console\Command;

class FillSiteIdInProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fillSiteIdInProduct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill site id in product.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::with([
            'supplier', 
            'productVariants.stock',
            'productVariants.futureStocks.currentOrder',
            'productVariants.currentStocks',
            'productVariants.allocations',
            'productVariants.backOrders',
        ])->get();

        $products->map(function (Product $product) {
            $siteId = $product->supplier->site_id;
            $product->fill(['site_id' => $siteId])->save();
            $product->productVariants()->update(['site_id' => $siteId]);
            $product->productVariants->map(function (ProductVariant $productVariant) {
                $productVariant->stock()->update(['site_id' => $productVariant->site_id]);
                $productVariant->currentStocks()->update(['site_id' => $productVariant->site_id]);
                $productVariant->futureStocks()->update(['site_id' => $productVariant->site_id]);
                $productVariant->allocations()->update(['site_id' => $productVariant->site_id]);
                $productVariant->backOrders()->update(['site_id' => $productVariant->site_id]);
                $productVariant->futureStocks->map(function (FutureStock $futureStock) {
                    $futureStock->currentOrder()->update(['site_id' => $futureStock->site_id]);
                });
            });
        });

        

        dump('Successful');
    }
}
