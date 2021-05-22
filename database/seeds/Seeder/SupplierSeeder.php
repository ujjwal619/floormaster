<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = app(\App\FMS\Site\Models\Site::class)->get();
        foreach ($sites as $site) {
            $supplier = \App\Data\Entities\Models\Supplier\Supplier::firstOrCreate([
                'trading_name' => 'Supplier 1',
                'site_id' => $site->id
            ]);

            $supplier->products()->create([
                'name' => 'Product 1',
                'category_id' => 1,
                'trade_sell' => [],
                'retail_sell' => [],
                'installed' => [],
                'list_cost' => 500
            ]);

            $product = \App\Data\Entities\Models\Product\Product::where('supplier_id', $supplier->id)->first();

            $product->productVariants()->firstOrCreate([
                'name' => 'Red'
            ]);
        }
    }
}
