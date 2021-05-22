<?php

namespace App\Data\Repositories\Product\Material;

use App\Data\Entities\Models\Product\MaterialProduct;
use App\Data\Repositories\Product\Material\MaterialProductRepository;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class MaterialProductEloquentRepository
 * @package App\Data\Repositories\Products\Material
 */
class MaterialProductEloquentRepository extends BaseRepository implements MaterialProductRepository
{
    /**
     * @var array
     */
    protected $filterFields = [];
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * MaterialProductEloquentRepository constructor.
     * @param Application     $application
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Application $application, DatabaseManager $databaseManager)
    {
        parent::__construct($application);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MaterialProduct::class;
    }

    /**
     * Get the paginated products with filter parameters.
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedProductsWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column'], $filters['column']);

        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

        if (!empty($searchQuery)) {
            $query = $query->where(
                function ($query) use ($searchQuery) {
                    $query->orWhere('name', 'like', "%{$searchQuery}%")
                        ->orWhere('unit_cost', 'like', "%{$searchQuery}%");
                }
            );
        }

        return $query->paginate($filters['per_page']);
    }

    /**
     * Create a product with variant.
     *
     * @param array $inputData
     * @return MaterialProduct
     * @throws \Exception
     */
    public function createProductWithVariants(array $inputData): MaterialProduct
    {
        $this->databaseManager->beginTransaction();
        try {
            $product = $this->create($inputData['product_type']);
            collect($inputData['variants'])->each(function ($variant) use ($product) {
                $product->productVariants()->create($variant);
            });
            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $product;
    }

    /**
     * Update a product with variant.
     *
     * @param array $updateData
     * @param int   $productId
     * @return MaterialProduct
     * @throws \Exception
     */
    public function updateProductWithVariants(array $updateData, int $productId): MaterialProduct
    {
        $this->databaseManager->beginTransaction();
        try {
            $product = $this->update($updateData['product_type'], $productId);
            collect($updateData['deletedVariants'])->each(function ($variantId) use ($product) {
                $product->productVariants()->where('id', $variantId)->delete();
            });
            collect($updateData['variants'])->each(function ($variant) use ($product) {
                if (array_has($variant, 'id')) {
                    $variant = array_only($variant, ['id', 'name']);

                    return $product->productVariants()->where('id', $variant['id'])->update($variant);
                }

                return $product->productVariants()->create($variant);
            });
            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $product;
    }

    /**
     * Deletes a product type with its variants.
     *
     * @param int $productId
     * @return bool
     * @throws \Exception
     */
    public function deleteProductWithVariants(int $productId)
    {
        $this->databaseManager->beginTransaction();
        try {
            $product = $this->find($productId);
            $product->productVariants()->delete();
            $product->delete();
            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return true;
    }
}
