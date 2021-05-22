<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class TemplateSeeder extends Seeder
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
            $site->templates()->firstOrCreate([
                'name' => 'Template 1',
                'labour_products' => [
                    [
                        'unit' => 1,
                        'total' => 1,
                        'product' => 'Labour 1',
                        'quantity' => 1
                    ]
                ],
                'material_products' => [
                    [
                        'unit' => 1,
                        'total' => 34,
                        'quantity' => 34,
                        'product_id' => 1,
                        'variant_id' => 1,
                        'product_name' => 'Product 1',
                        'variant_name' => 'Red'
                    ]
                ]
            ]);
        }
    }
}
