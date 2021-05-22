<?php

namespace App\Domain\Admin\Controllers\Product;

use App\Domain\Admin\Requests\Product\ProductRequest;
use App\Domain\Admin\Services\Product\ProductService;
use App\Domain\Admin\Services\Supplier\SupplierService;
use App\FMS\Supplier\Manager as SupplierManager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class ProductController extends AdminController
{
    private $productService;
    private $supplierService;
    private $selectListHelper;
    private $supplierManager;

    public function __construct(
        ProductService $productService, 
        SupplierService $supplierService, 
        SelectListHelper $selectListHelper,
        SupplierManager $supplierManager
    ) {
        $this->productService = $productService;
        $this->supplierService = $supplierService;
        $this->selectListHelper = $selectListHelper;
        $this->supplierManager = $supplierManager;
    }

    public function index(Request $request)
    {
        $supplier = $request->get('supplier');
        $selectedSupplier = new stdClass();
        if (!$supplier) {
            $latestSupplierCollection = $this->supplierManager->findLatest($request->user());
            if ($latestSupplierCollection) {
                $selectedSupplier = $this->supplierManager->find($latestSupplierCollection->id);
            }
        } else {
            //TODO: Block unauthorized site with sharing store enabled
            $sites = $request->user()->getSiteIds();
            $selectedSupplier = $this->supplierManager->find($supplier);
            // if (!$sites->contains($selectedSupplier->site_id)) {
            //     abort('401', 'Unauthorized site.');
            // }
        }

        $products = $this->productService->getAll(!$selectedSupplier->count() ? null : $selectedSupplier->id);
        $categories = $this->selectListHelper->getAllProductCategories();

        return view('admin.modules.product.index', compact('products', 'selectedSupplier', 'categories'));
    }

    public function create(Request $request)
    {
        $supplier = $request->get('supplier');
        $latestSupplier = collect([]);
        if ($this->supplierService->findLatest()) {
            $latestSupplier = $this->supplierService->findLatest();
        }
        $selectedSupplier = $supplier ? $this->supplierService->findById($supplier) : $latestSupplier;
        if ($selectedSupplier) {
            $selectedSupplier->load('site');
        }
        $suppliers = $this->supplierService->getAll();
        $categories = $this->selectListHelper->getAllProductCategories();

        return view('admin.modules.product.create', compact('suppliers', 'selectedSupplier', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $this->productService->store($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new product.', 'error');

            return $this->sendError('Unable to create new product.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new product.');
    }

    public function edit(int $id)
    {
        $product = $this->productService->find($id);
        $selectedSupplier = $this->supplierService->findById($product->supplier_id);
        if ($selectedSupplier) {
            $selectedSupplier->load('site');
        }
        $suppliers = $this->supplierService->getAll();
        $categories = $this->selectListHelper->getAllProductCategories();

        return view('admin.modules.product.edit', compact('suppliers', 'selectedSupplier', 'categories', 'product'));
    }

    public function update(int $id, ProductRequest $request)
    {
        try {
            $this->productService->update($id, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update product.', 'error');

            return $this->sendError($exception->getMessage(), $exception->getCode());
        }

        return $this->sendSuccessResponse([], 'Successfully updated product.');
    }

    public function destroy($id)
    {
        try {
            $this->productService->delete((int)$id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('product not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to delete product.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);

        }
        return $this->sendSuccessResponse([], 'Successfully deleted product.');
    }
}
