<?php

namespace App\Domain\Admin\Controllers\Supplier;

use App\Domain\Admin\Requests\Supplier\SupplierRequest;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\Domain\Admin\Services\Supplier\SupplierService;
use App\Domain\Admin\Services\Users\UserService;
use App\FMS\Supplier\Manager as SupplierManager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class SupplierController
 * @package App\Domain\Admin\Controllers\Supplier
 */
class SupplierController extends AdminController
{
    /**
     * @var SupplierService
     */
    protected $supplierService;
    /**
     * @var JobSourceService
     */
    private $jobSourceService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CustomerController constructor.
     * @param SupplierService  $supplierService
     * @param JobSourceService $jobSourceService
     * @param UserService      $userService
     */
    public function __construct(
        SupplierService $supplierService, 
        JobSourceService $jobSourceService, 
        UserService $userService,
        SupplierManager $supplierManager
    ) {
        $this->middleware(['can:suppliers']);
        $this->middleware('permission:suppliers.add', ['only' => 'store']);
        $this->middleware('permission:suppliers.edit', ['only' => 'update']);
        $this->jobSourceService = $jobSourceService;
        $this->userService      = $userService;
        $this->supplierService  = $supplierService;
        $this->supplierManager  = $supplierManager;
    }

    /**
     * Display the index page for the customers module.
     */
    public function index()
    {
        return view('admin.modules.suppliers.index');
    }

    /**
     * Display a form to create new Supplier.
     */
    public function create()
    {
        return view('admin.modules.suppliers.index');
    }

    /**
     * Show the details of the Supplier.
     * @param $supplierId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($supplierId)
    {
        $supplier = $this->supplierService->findById($supplierId);

        return view('admin.modules.suppliers.show', compact('supplier'));
    }

    /**
     * @param $supplierId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($supplierId)
    {
        try {
            $supplier           = $this->supplierService->findById((int)$supplierId);
            $suppliers          = $this->supplierService->getAll();

        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('admin.modules.suppliers.edit', compact('supplier', 'suppliers'));
    }

    /**
     * Create new customer.
     * @param SupplierRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SupplierRequest $request)
    {
        try {
            $details = $request->all();
            throw_if(
                $this->supplierManager->findWhere([
                    'site_id' => $details['site_id'], 
                    'trading_name' => $details['trading_name']
                ]), 
                new \Exception('Supplier already created with same name.')
            );

            $supplier = $this->supplierService->create($details);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new Supplier.', 'error');

            return $this->sendError('Unable to create new Supplier.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($supplier->toArray(), 'Successfully created new Supplier.');
    }

    /**
     * @param SupplierRequest $request
     * @param                 $supplierId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupplierRequest $request, $supplierId)
    {
        try {
            $details = $request->all();
            throw_if(
                $this->supplierManager->findWhere([
                    'site_id' => $details['site_id'], 
                    'trading_name' => $details['trading_name'],
                    ['id' , '<>', $supplierId]
                ]), 
                new \Exception('Supplier already created with same name.')
            );

            $supplier = $this->supplierService->update($details, (int)$supplierId);
        } catch (\Exception $exception) {
            dd($exception);

            logger()->error($exception);
            flash('Unable to update Supplier.', 'error');

            return $this->sendError('Unable to update Supplier.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($supplier->toArray(), 'Successfully updated Supplier.');
    }

    /**
     * Get the paginated Suppliers with filters.
     */
    public function getPaginatedSuppliers()
    {
        $suppliers = $this->supplierService->getPaginatedSuppliersForTable(request()->all());

        return $suppliers;
    }

    /**
     * @param $supplierId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($supplierId)
    {
        try {
            $this->supplierService->delete((int)$supplierId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Supplier not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Supplier.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Supplier deleted successfully!');
    }
}
