<?php

namespace App\FMS\ProductCategory;

use App\Data\Entities\Models\Product\Category;

class Manager
{
    private $product;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function findWhere(array $conditions = [])
    {
        return $this->category->where($conditions)->first();
    }
}
