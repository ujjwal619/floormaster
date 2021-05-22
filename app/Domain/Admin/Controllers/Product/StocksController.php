<?php

namespace App\Domain\Admin\Controllers\Product;

use App\Constants\General;
use App\Domain\Admin\Requests\Product\StockRequest;
use App\Domain\Admin\Services\Product\LabourProductService;
use App\Domain\Admin\Services\Product\MaterialProductService;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class StocksController
 * @property SelectListHelper selectListHelper
 * @package App\Domain\Admin\Controllers\Product
 */
class StocksController extends AdminController
{
    protected $selectListHelper;
    protected $productService;

    /**
     * ProductController constructor.
     *
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

        $productType = request()->route('product_type');
        if ( !in_array($productType, General::getAllProductTypes()) ) {
            abort(404);
        }

        if ( $productType == General::MATERIAL ) {
            $this->productService = $materialProductService;
        } else {
            if ( $productType == General::LABOUR ) {
                $this->productService = $labourProductService;
            }
        }

    }

    /**
     * Get all stocks of the provided product.
     *
     * @param string $productType
     * @param        $productID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $productType, $productID)
    {
        try {
            $product = $this->productService->findById((int) $productID);

        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('admin.modules.products.stock.index', compact('product', 'productType'));
    }

    /**
     * @param string       $productType
     * @param    int       $productID
     * @param StockRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(string $productType, $productID, StockRequest $request)
    {
        try {
            $product = $this->productService->findById($productID);
            $product->stocks()->create($request->all());
        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated stock');

    }
}
