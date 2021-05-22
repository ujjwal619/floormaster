<?php

namespace App\Domain\Admin\Controllers\Customers;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\Domain\Admin\Requests\Jobs\JobsRequest;
use App\Domain\Admin\Services\Booking\BookingService;
use App\Domain\Admin\Services\Booking\BookingTypeService;
use App\Domain\Admin\Services\Jobs\JobService;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\Domain\Admin\Services\Product\LabourProductService;
use App\Domain\Admin\Services\Product\MaterialProductService;
use App\Domain\Admin\Services\Quotes\QuoteService;
use App\Domain\Admin\Services\Settings\Terms\TermsService;
use App\Domain\Admin\Services\Template\TemplateService;
use App\Domain\Admin\Services\Users\UserService;
use App\FMS\Account\Manager as AccountManager;
use App\FMS\Job\Manager as JobManager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Admin\Services\InstallationComplaint\InstallationComplaintService;
use App\FMS\Invoice\Events\CalculateInvoiceTotal;
use App\FMS\Job\Events\CalculateJobTotal;
use App\FMS\Job\Events\InvoiceCreated;
use App\FMS\Job\Events\ReceiptCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class JobController
 * @package App\Domain\Admin\Controllers\Customers
 */
class JobController extends AdminController
{
    /**
     * @var QuoteService
     */
    protected $quoteService;

    /**
     * @var JobService
     */
    protected $jobService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var MaterialProductService
     */
    protected $productService;
    /**
     * @var LabourProductService
     */
    protected $labourProductService;
    /**
     * @var JobSourceService
     */
    protected $jobSourceService;
    /**
     * @var TermsService
     */
    protected $termsService;

    /**
     * @var SelectListHelper
     */
    protected $selectListHelper;

    /**
     * @var TemplateService
     */
    protected $templateService;

    /**
     * @var BookingService
     */
    protected $bookingService;

    /**
     * @var InstallationComplaintService
     */
    protected $complaintService;

    /**
     * @var BookingTypeService
     */
    protected $bookingTypeService;

    protected $jobManager;

    protected $accountManager;

    /**
     * JobController constructor.
     *
     * @param QuoteService           $quoteService
     * @param JobService             $jobService
     * @param UserService            $userService
     * @param MaterialProductService $productService
     * @param LabourProductService   $labourProductService
     * @param JobSourceService       $jobSourceService
     * @param TermsService           $termsService
     * @param SelectListHelper       $selectListHelper
     * @param TemplateService        $templateService
     * @param BookingService         $bookingService
     * @param BookingTypeService     $bookingTypeService
     * @param InstallationComplaintService  $complaintService
     */
    public function __construct(
        QuoteService $quoteService,
        JobService $jobService,
        UserService $userService,
        MaterialProductService $productService,
        LabourProductService $labourProductService,
        JobSourceService $jobSourceService,
        TermsService $termsService,
        SelectListHelper $selectListHelper,
        TemplateService $templateService,
        BookingService $bookingService,
        BookingTypeService $bookingTypeService,
        InstallationComplaintService $complaintService,
        JobManager $jobManager,
        AccountManager $accountManager
    ) {
        $this->quoteService         = $quoteService;
        $this->jobService           = $jobService;
        $this->userService          = $userService;
        $this->productService       = $productService;
        $this->labourProductService = $labourProductService;
        $this->jobSourceService     = $jobSourceService;
        $this->termsService         = $termsService;
        $this->selectListHelper     = $selectListHelper;
        $this->templateService      = $templateService;
        $this->bookingService       = $bookingService;
        $this->bookingTypeService   = $bookingTypeService;
        $this->complaintService     = $complaintService;
        $this->jobManager = $jobManager;
        $this->accountManager = $accountManager;

        $this->middleware(['permission:job.access']);
        $this->middleware(
            'permission:job.access.view.costing', 
            ['only' => ['edit']]
        );
        $this->middleware(
            'permission:job.access.edit.screen.1|job.access.edit.costing', 
            ['only' => ['update']]
        );

        $this->middleware(
            'permission:job.access.invoice.jobs', 
            ['only' => ['addInvoice', 'addReceipt']]
        );
    }

    /**
     * Display the index page for the jobs.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $job = $this->jobManager->findLatest($request->user());

            if (!$job) {
                return redirect()->route('admin.jobs.create');
            }

            return redirect()->route('admin.jobs.edit', $job->id);
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e);
            abort(404);
        }
    }

    /**
     * Get the paginated jobs for table.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedJobs()
    {
        $jobs = $this->jobService->getPaginatedJobsForTable(request()->all());

        return $jobs;
    }

    /**
     * Show the form for the job create.
     */
    public function create()
    {
        try {
            $selectedTemplates = (object)[];
            if (!empty(request()->get('templates'))) {
                $selectedTemplates = $this->templateService->getSelected(explode(',', request()->get('templates')));
            }
            $customers      = $this->selectListHelper->getAllCustomers();
            $products       = $this->selectListHelper->getAllProducts();
            $labourProducts = $this->labourProductService->getAll();
            $jobSources     = $this->jobSourceService->all();
            $templates      = $this->selectListHelper->getAllTemplates();

            return view('admin.modules.jobs.create', compact('customers', 'products', 'labourProducts', 'jobSources', 'templates', 'selectedTemplates'));
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    /**
     * Store the job.
     *
     * @param JobsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(JobsRequest $request)
    {
        $inputData = $request->except(['labour', 'material']);
        try {
            $this->jobService->createJob($inputData);

            flash('Successfully added new job.', 'success');
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);

            flash('Unable to add new job.', 'error');

            return $this->sendError('Unable to add new job.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added new job.');
    }

    /**
     * Show the edit form for the job edit.
     *
     * @param $jobId
     *
     * @return mixed
     */
    public function edit($jobId, Request $request)
    {
        $user = $request->user();
        try {
            $job            = $this->jobService->findById((int)$jobId);
            // dd($job);
            $products       = $this->selectListHelper->getAllProducts();
            $labourProducts = $this->labourProductService->getAll();
            $jobSources     = $this->jobSourceService->all();
            $staffs         = $this->selectListHelper->getAllUsers();
            $templates      = $this->selectListHelper->getAllTemplates();
            $bookings       = $this->bookingService->getByJob($job->job_id);
            // dd($bookings);
            $bookingTypes   = $this->bookingTypeService->getAll();
            $complaints     = $this->complaintService->getByJob($job->id);
            $invoices       = $job->invoices;
            $site           = $job->site;

            $previous = $this->jobManager->findPrevious($user, $jobId);
            $next     = $this->jobManager->findNext($user, $jobId);

            return view('admin.modules.jobs.edit',
                compact('job', 'products', 'labourProducts', 'jobSources', 'previous',
                    'next', 'templates', 'staffs', 'bookings', 'bookingTypes', 'complaints', 'invoices', 'site'));

        } catch (ModelNotFoundException $exception) {
            abort(404);

        }
    }

    /**
     * Update the job
     *
     * @param JobsRequest $request
     * @param             $jobId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(JobsRequest $request, $jobId)
    {
        $updateData = $request->except(['labour', 'material', 'jobSource']);

        try {
            $this->jobService->update($updateData, (int)$jobId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update job.', 'error');

            return $this->sendError('Unable to update job.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated job.');
    }

    /**
     * @param $jobId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($jobId)
    {
        try {
            $this->jobService->delete((int)$jobId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Job not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            flash()->error('Unable to delete job');

            return redirect()->back();

        }
        flash()->success('Successfully deleted the job');

        return redirect()->route('admin.jobs.index');
    }

    /**
     * @param Request $request
     * @param         $jobId
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addInvoice(Request $request, $jobId)
    {
        //TODO: date range validation
        $this->validate($request, [
            'date'           => 'required|date',
            'amount'         => 'required|numeric',
        ]);

        try {
            $inputData = $request->all();
            $job = $this->jobService->findById((int)$jobId);
            $gst = $job->gst ?? $job->site()->gst ?? config('fms.gst');
            $inputData['gst'] = $gst;
            $inputData['net_invoice'] = number_format($inputData['amount'], 2, '.', '');
            $inputData['gst_amount'] = number_format(($inputData['amount'] * $gst) / 100, 2, '.', '');
            $inputData['amount'] = number_format($inputData['amount'] + $inputData['gst_amount'], 2, '.', '');
            // dd($inputData);
            $inputData['remarks'] = $job->remarks;
            $invoice = $job->invoices()->create($inputData);
            event(new InvoiceCreated($invoice, $job));
            event(new CalculateInvoiceTotal($invoice));
            event(new CalculateJobTotal($job));
        } catch (\Exception $exception) {
            dd($exception);
            return $this->sendError('Unable to add new invoice.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($invoice->toArray(), 'Successfully added the invoice.');

    }

    public function showInvoicePrint(Job $job, Invoice $invoice)
    {
        $invoice = $invoice->fresh([
            'job.customer', 
            'job.site',
            'job.invoices',
        ])->toArray();

        return view('admin.modules.billings.print', [
            'invoice' => $invoice
        ]);
    }

    public function addReceipt(int $jobId, Request $request)
    {
        //TODO: date range validation
        $this->validate($request, [
            'receipt_date'   => 'date',
            'amount'         => 'required|numeric',
        ]);

        $inputData = $request->all();

        try {
            $job = $this->jobService->findById((int)$jobId);

            $receipt = $job->receipts()->create($inputData);

            event(new ReceiptCreated($receipt, $job));
            if ($invoice = $receipt->invoice) {
                event(new CalculateInvoiceTotal($invoice));
            }
        } catch (\Exception $exception) {
            return $this->sendError('Unable to add new receipt.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added the receipt.');
    }

    public function invoices(Job $job)
    {
        $job->load(['invoices.receipts', 'invoices.expenses']);

        return new JsonResponse([
            'data' => $job->invoices
        ]);
    }

    public function nonAllocatedReceipts(int $jobId, Request $request)
    {
        $dateRangeFilter = $request->get('date_range_filter', false);
        $job            = $this->jobService->findById($jobId);
        $isSuperUser = request()->user()->hasRole('super_admin');
        $from = getDateRange($isSuperUser, 'start'); 
        $to = getDateRange($isSuperUser, 'end'); 

        $receipts = $job->receipts()
        ->where('invoice_id', null);

        if ($dateRangeFilter) {
            $receipts->whereBetween('receipt_date', [$from, $to]);
        }
        
        $receipts = $receipts->get();

        return new JsonResponse([
            'data' => $receipts
        ]);
    }

    public function receipts(int $jobId)
    {
        $job            = $this->jobService->findById($jobId);
        return new JsonResponse([
            'data' => $job->receipts()->whereNotNull('invoice_id')->get()
        ]);
    }
}
