<?php

namespace App\Domain\Admin\Controllers\Contractor;

use App\Data\Entities\Models\Contractor\Contractor;
use App\Domain\Admin\Requests\Contractor\ContractorRequest;
use App\Domain\Admin\Services\Account\AccountService;
use App\Domain\Admin\Services\Contractor\ContractorService;
use App\FMS\Contractor\Manager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractorController extends AdminController
{
    private $service;

    private $selectListHelper;

    private $accountService;

    private $contractorManager;

    public function __construct(ContractorService $service, SelectListHelper $selectListHelper, AccountService $accountService, Manager $contractorManager)
    {
        $this->service = $service;
        $this->selectListHelper = $selectListHelper;
        $this->accountService = $accountService;
        $this->contractorManager = $contractorManager;

        $this->middleware(['permission:contractors']);
        $this->middleware(
            'permission:contractors.edit.record', 
            ['only' => ['update']]
        );
        $this->middleware(
            'permission:contractors.add.contractor', 
            ['only' => ['store']]
        );
        $this->middleware(
            'permission:job.access.allocate.labour|contractors.add.payment.due', 
            ['only' => ['storePayment']]
        );
    }

    public function index(Request $request)
    {
        try {
            $contractor = $this->contractorManager->findLatest($request->user());

            if (!$contractor) {
                return redirect()->route('admin.contractors.create');
            }

            return redirect()->route('admin.contractors.edit', $contractor->id);
        } catch (\Exception $e) {
            logger()->error($e);
            abort(404);
        }
    }

    public function create()
    {
        try {
            $suppliers = $this->selectListHelper->getAllSuppliers();
            $liabilityAccount = $this->accountService->getByFamily(2, 1);
            $costOfSalesAccount = $this->accountService->getByFamily(6, 1);

            return view('admin.modules.contractors.index', compact('suppliers', 'liabilityAccount', 'costOfSalesAccount'));
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    public function store(ContractorRequest $request)
    {
        $inputData = $request->all();
        try {
            $this->service->create($inputData);

            flash('Successfully added new contractor.', 'success');
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);

            flash('Unable to add new contractor.', 'error');

            return $this->sendError('Unable to add new contractor.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added new contractor.');
    }

    public function edit(Contractor $contractor, Request $request)
    {
        $user = $request->user();
        try {
            $suppliers = $this->selectListHelper->getAllSuppliers($contractor->site_id);
            $liabilityAccount = $this->accountService->getByFamily(2, $contractor->site_id);
            $costOfSalesAccount = $this->accountService->getByFamily(6, $contractor->site_id);
            // create different api for payments because there is a permission for that
            $payments = $contractor->payments()->get()->load('job.customer');
            $jobs = $this->selectListHelper->getAllJobs();
            // create different api to get remittanceItems of contractor because there is a permission for that
            $contractor = $contractor->fresh(['site', 'remittanceItems.remittance']);

            $previous = $this->contractorManager->findPrevious($user, $contractor->id);
            $next = $this->contractorManager->findNext($user, $contractor->id);

            return view('admin.modules.contractors.index', compact(
                    'contractor',
                    'previous',
                    'next',
                    'suppliers',
                    'liabilityAccount',
                    'costOfSalesAccount',
                    'payments',
                    'jobs'
                )
            );
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    public function update(ContractorRequest $request, int $contractorId)
    {
        try {
            $this->service->update($request->all(), $contractorId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update contractor.', 'error');

            return $this->sendError('Unable to update contractor.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated contractor.');
    }

    public function destroy(int $contractorId)
    {
        try {
            $this->service->delete($contractorId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Contractor not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Contractor.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->route('admin.contractors.index');
    }

    public function check(Request $request)
    {
        $tfn = $request->get('tfn', null);
        if (!$tfn) {
            throw new \Exception('Not Available');
        }

        if (!$contractor = $this->service->findByTfn($tfn)) {
            throw new \Exception('Not Available');
        }

        return $contractor;
    }

    public function storePayment(int $contractorId, Request $request)
    {
        //TODO: date range validation
        // $isSuperUser = request()->user()->hasRole('super_admin');
        // $from = getDateRange($isSuperUser, 'start'); 
        // $to = getDateRange($isSuperUser, 'end'); 

        // $request->validate([
        //     'date' => 'date|required|after_or_equal:'. $from .'|before_or_equal' . $to,
        // ]);

        $inputData = $request->all();

        // dd($inputData);
        try {
            $this->service->createPayment($contractorId, $inputData);

            flash('Successfully added new payments due for contractor.', 'success');
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);

            flash('Unable to add new payments due for contractor.', 'error');

            return $this->sendError('Unable to add new payments due for contractor.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added new payments due for contractor.');
    }

    public function payments(Contractor $contractor)
    {

    }
}
