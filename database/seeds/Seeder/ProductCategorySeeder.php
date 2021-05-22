<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Data\Entities\Models\Product\Category::create([
            'title' => 'Category 1',
            'name' => 'category-1'
        ]);
    }
}
