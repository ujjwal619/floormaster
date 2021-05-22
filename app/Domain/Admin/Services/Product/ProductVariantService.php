<?php

namespace App\Domain\Admin\Services\Product;

use App\Data\Repositories\Product\ProductVariantRepository;

class ProductVariantService
{
    private $repository;

    public function __construct(ProductVariantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id)
    {
        return $this->repository->with(['product.supplier'])->find($id);
    }
}
