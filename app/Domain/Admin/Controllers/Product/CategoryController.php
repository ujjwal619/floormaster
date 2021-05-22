<?php

namespace App\Domain\Admin\Controllers\Product;

use App\Constants\DBTable;
use App\Data\Entities\Models\Product\Category;
use App\Domain\Admin\Services\Product\Category\CategoryService;
use App\FMS\ProductCategory\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Category controller class.
 */
class CategoryController extends AdminController
{
    /**
     * CategoryService $categoryService.
     *
     */
    protected $categoryService;
    protected $categoryManager;

    /**
     * CategoryService class constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(
        CategoryService $categoryService,
        Manager $categoryManager
    ) {
        $this->categoryService = $categoryService;
        $this->categoryManager = $categoryManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.products.categories.index');
    }

    /**
     * Store a newly created product category in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'title' => 'required|max:30',
                'site_id' => 'required|numeric',
            ]
        );

        try {
            $details = $request->all();
            throw_if(
                !!$this->categoryManager->findWhere([
                    'site_id' => $details['site_id'], 
                    'title' => $details['title']
                ]), 
                new \Exception('Category already created with same name.')
            );

            $this->categoryService->createCategory($details);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new category.', 'error');

            return $this->sendError('Unable to create new Category.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new category.');
    }

    /**
     * Get the details of the category provided by id.
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails($categoryId)
    {
        try {
            $category = $this->categoryService->findById((int)$categoryId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Unable to fetch details');
        }

        return $this->sendSuccessResponse($category->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param                           $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $categoryId)
    {
        $this->validate($request, ['title' => 'required|max:30', 'site_id' => 'required|numeric']);
        $details = $request->only(['site_id', 'title', 'inventory_account_id','cos_account_id']);
        $category = Category::where([
            'site_id' => $details['site_id'], 
            'title' => $details['title'],
        ])->where('id', '<>', $categoryId)->first();
        try {
            throw_if(
                !!$category, 
                new \Exception('Category already created with same name.')
            );
            $this->categoryService->updateCategory($details, $categoryId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return $this->sendError('Could not updated category.');
        }

        return $this->sendSuccessResponse([], 'Successfully updated category.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId)
    {
        try {
            $this->categoryService->delete((int)$customerId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Category not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to delete Category.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Category deleted successfully!');
    }

    /**
     * Returns the paginated categories.
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getPaginatedCategories()
    {
        $customers = $this->categoryService->getPaginatedCategoriesForTable(request()->all());

        return $customers;
    }
}
