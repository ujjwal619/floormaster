<?php

namespace App\Domain\Admin\Controllers\Customers;

use App\Constants\AuthRoles;
use App\Data\Entities\Models\Customer\Customer;
use App\Domain\Admin\Requests\Customers\CustomerRequest;
use App\Domain\Admin\Services\Customers\CustomerService;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\Domain\Admin\Services\Users\UserService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class CustomerController
 * @package App\Domain\Admin\Controllers\Customers
 */
class CustomerController extends AdminController
{
    /**
     * @var CustomerService
     */
    protected $customerService;
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
     * @param CustomerService  $customerService
     * @param JobSourceService $jobSourceService
     * @param UserService      $userService
     */
    public function __construct(CustomerService $customerService, JobSourceService $jobSourceService, UserService $userService)
    {
        $this->customerService  = $customerService;
        $this->jobSourceService = $jobSourceService;
        $this->userService      = $userService;
    }

    /**
     * Display the index page for the customers module.
     */
    public function index()
    {
        return view('admin.modules.customers.index');
    }

    /**
     * Display a form to create new customer.
     */
    public function create()
    {
        $jobSources  = $this->jobSourceService->all();
        $salesStaffs = [];

        return view('admin.modules.customers.create', compact('jobSources', 'salesStaffs'));
    }

    /**
     * Show the details of the customer.
     * @param $customerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($customerId)
    {
        $customer = $this->customerService->findById($customerId);

        return view('admin.modules.customers.show', compact('customer'));
    }

    /**
     * @param $customerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($customerId)
    {
        try {
            $customer           = $this->customerService->findById((int)$customerId);
            $jobSources         = $this->jobSourceService->all();
            $salesStaffs        = [];
            $selectedJobSources = $customer->jobSources->pluck('id');
            $selectedSales      = $customer->sales->pluck('id');
            $sites              = $customer->sites->all();
            $settings           = $customer->setting;
        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('admin.modules.customers.edit', compact('customer', 'jobSources', 'salesStaffs', 'selectedJobSources', 'selectedSales', 'sites', 'settings'));
    }

    /**
     * Create new customer.
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        try {
            $this->customerService->createCustomer($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new customer.', 'error');

            return $this->sendError('Unable to create new user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new user.');
    }

    /**
     * @param CustomerRequest $request
     * @param                 $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomerRequest $request, $customerId)
    {
        try {
            $this->customerService->update($request->all(), (int)$customerId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update customer.', 'error');

            return $this->sendError('Unable to update customer.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated customer.');
    }

    /**
     * Get the paginated customers with filters.
     */
    public function getPaginatedCustomers()
    {
        $customers = $this->customerService->getPaginatedCustomersForTable(request()->all());

        return $customers;
    }

    /**
     * @param $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId)
    {
        try {
            $this->customerService->delete((int)$customerId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Customer not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Customer.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Customer deleted successfully!');
    }

    /**
     * Get customer details by customer id.
     * @param $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerDetails($customerId)
    {
        try {
            /** @var Customer $customer */
            $customer = $this->customerService->findById($customerId);
        } catch (ModelNotFoundException $exception) {
            $this->sendError('Customer not found.', Response::HTTP_NOT_FOUND);
        }

        return $this->sendSuccessResponse($customer->toArray());
    }

    /**
     * @param $customerId
     * @return mixed
     */
    public function getLatestQuoteId($customerId)
    {
        $quote = $this->customerService->getLatestQuote($customerId);

        return $quote ? $quote->id : 'null';
    }
}
