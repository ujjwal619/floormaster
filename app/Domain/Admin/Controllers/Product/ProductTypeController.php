<?php

namespace App\Domain\Admin\Controllers\Product;

use App\Constants\General;
use App\Domain\Admin\Requests\Product\ProductTypeRequest;
use App\Domain\Admin\Services\Product\LabourProductService;
use App\Domain\Admin\Services\Product\MaterialProductService;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/**
 * Class ProductTypeController
 * @package App\Domain\Admin\Controllers\Product
 */
class ProductTypeController extends AdminController
{
    /**
     * @var mixed
     */
    protected $productService;
    /**
     * @var SelectListHelper
     */
    protected $selectListHelper;

    /**
     * ProductController constructor.
     * @param LabourProductService   $labourProductService
     * @param MaterialProductService $materialProductService
     * @param SelectListHelper       $selectListHelper
     */
    public function __construct(
        LabourProductService $labourProductService,
        MaterialProductService $materialProductService,
        SelectListHelper $selectListHelper
    ) {
        $this->selectListHelper = $selectListHelper;

        if(Route::currentRouteName() != "admin.products.type.index" ) {
            $productType = request()->route('product_type');
            if ($productType == General::MATERIAL) {
                $this->productService = $materialProductService;
            } elseif ($productType == General::LABOUR) {
                $this->productService = $labourProductService;
            }
        }
    }

    /**
     * List all the products.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $productTypes = General::getAllProductTypes();

        return view('admin.modules.products.index', compact('productTypes'));
    }

    /**
     * Returns all the data for products for data table.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getPaginatedProducts()
    {
        return $this->productService->getPaginatedProductsForDataTable(request()->all());
    }

    /**
     * Shows form for creating a product.
     *
     * @param string $productType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(string $productType)
    {
        $categories = $this->selectListHelper->getAllProductCategories();

        return view('admin.modules.products.create', compact('productType', 'categories'));
    }

    /**
     * Stores the product in database.
     *
     * @param ProductTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductTypeRequest $request)
    {
        try {
            $this->productService->store($request->all());
        } catch (\Exception $exception) {
            logger(sprintf("Unable to create product because:%s", $exception->getMessage()));

            return $this->sendError('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated product type.');
    }

    /**
     * Shows form for editing a product.
     *
     * @param string $productType
     * @param        $productTypeId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $productType, $productTypeId)
    {
        $product    = $this->productService->findById((int) $productTypeId);
        $categories = $this->selectListHelper->getAllProductCategories();
        $variants   = $product->productVariants->all();

        return view('admin.modules.products.edit', compact('productType', 'product', 'variants', 'categories'));
    }

    /**
     * Updates the product in database.
     *
     * @param string             $productType
     * @param                    $productId
     * @param ProductTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $productType, $productId, ProductTypeRequest $request)
    {
        try {
            $this->productService->update((int)$productId, $request->all());
        } catch (ModelNotFoundException $exception) {
            abort(404);
        } catch (\Exception $exception) {
            logger(sprintf("Unable to update product because: %s", $exception->getMessage()));

            return $this->sendError('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated product type.');
    }

    /**
     * Deletes a product.
     *
     * @param string $productType
     * @param        $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $productType, $productId)
    {
        try {
            $this->productService->destroy((int) $productId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Job Source not found.', Response::HTTP_NOT_FOUND);
        } catch(\Exception $exception) {
            logger(sprintf("Unable to delete product because:%s", $exception->getMessage()));

            return $this->sendError('Unable to delete product.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Product deleted successfully!');
    }
}
