<?php

namespace App\Domain\Admin\Services\Product\Category;

use App\Data\Entities\Models\Product\Category;
use App\Data\Repositories\Product\Category\CategoryRepository;
use App\Domain\Admin\Resources\Products\CategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryService.
 * @package App\Domain\Admin\Services\Product\Category
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get the paginated categories for the data table.
     * @param array $filters
     * @return JsonResource
     */
    public function getPaginatedCategoriesForTable(array $filters): JsonResource
    {
        $categories = $this->categoryRepository->getPaginatedCategoriesWith($filters);

        return CategoryResource::collection($categories);
    }

    /**
     *
     * @param array $inputData
     *
     * @return mixed
     */
    public function createCategory(array $inputData)
    {
        $inputData['name'] = $this->generateName(str_slug($inputData['title']));

        return $this->categoryRepository->create($inputData);
    }

    /**
     * Generate.
     * @param string $name
     * @return string
     */
    private function generateName(string $name): string
    {
        $newName = $name;
        $count   = 1;
        while (1) {
            $result = $this->categoryRepository->nameExists($newName);

            if ($result === false) {
                break;
            }

            $newName = sprintf('%s-%s', $name, $count++);
        }

        return $newName;
    }

    /**
     * Returns the product category model by id.
     * @param int $categoryId
     * @return Category
     * @throws ModelNotFoundException
     */
    public function findById(int $categoryId): Category
    {
        return $this->categoryRepository->find($categoryId, ['id', 'name', 'title', 'description']);
    }

    /**
     * Update product category.
     * @param array $updateData
     * @param       $categoryId
     * @return Category
     */
    public function updateCategory(array $updateData, $categoryId): Category
    {
        return $this->categoryRepository->update($updateData, $categoryId);
    }

    /**
     * Delete the category when the category id is provided.
     * @param int $categoryId
     * @return bool
     */
    public function delete(int $categoryId): bool
    {
        return (bool)$this->categoryRepository->delete($categoryId);
    }
}
