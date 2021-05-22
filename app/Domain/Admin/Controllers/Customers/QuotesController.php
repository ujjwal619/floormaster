<?php

namespace App\Domain\Admin\Controllers\Customers;

use App\Constants\AuthRoles;
use App\Data\Entities\Models\Quote\Quote;
use App\Domain\Admin\Requests\Quotes\QuotesRequest;
use App\Domain\Admin\Resources\Products\LabourProductResource;
use App\Domain\Admin\Services\Customers\CustomerService;
use App\Domain\Admin\Services\Jobs\JobService;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\Domain\Admin\Services\Product\LabourProductService;
use App\Domain\Admin\Services\Product\MaterialProductService;
use App\Domain\Admin\Services\Quotes\QuoteService;
use App\Domain\Admin\Services\Settings\Terms\TermsService;
use App\Domain\Admin\Services\Template\TemplateService;
use App\Domain\Admin\Services\Booking\BookingService;
use App\Domain\Admin\Services\Booking\BookingTypeService;
use App\Domain\Admin\Services\Users\UserService;
use App\FMS\Account\Manager as AccountManager;
use App\FMS\Quote\Manager as QuoteManager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Class QuotesController
 * @package App\Domain\Admin\Controllers\Customers
 */
class QuotesController extends AdminController
{
    /**
     * @var CustomerService
     */
    protected $customerService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var MaterialProductService
     */
    protected $productService;
    /**
     * @var LabourProductResource
     */
    protected $labourProductService;
    /**
     * @var JobSourceService
     */
    protected $jobSourceService;
    /**
     * @var QuoteService
     */
    protected $quoteService;
    /**
     * @var JobService
     */
    protected $jobService;
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
     * @var BookingTypeService
     */
    protected $bookingTypeService;

    protected $quoteManager;

    protected $accountManager;


    /**
     * QuotesController constructor.
     *
     * @param CustomerService        $customerService
     * @param UserService            $userService
     * @param MaterialProductService $productService
     * @param LabourProductService   $labourProductResource
     * @param JobSourceService       $jobSourceService
     * @param QuoteService           $quoteService
     * @param JobService             $jobService
     * @param TermsService           $termsService
     * @param SelectListHelper       $selectListHelper
     * @param TemplateService        $templateService
     * @param BookingService         $bookingService
     * @param BookingTypeService     $bookingTypeService
     */
    public function __construct(
        CustomerService $customerService,
        UserService $userService,
        MaterialProductService $productService,
        LabourProductService $labourProductResource,
        JobSourceService $jobSourceService,
        QuoteService $quoteService,
        JobService $jobService,
        TermsService $termsService,
        SelectListHelper $selectListHelper,
        TemplateService $templateService,
        BookingService $bookingService,
        BookingTypeService $bookingTypeService,
        QuoteManager $quoteManager,
        AccountManager $accountManager
    ) {
        $this->customerService      = $customerService;
        $this->userService          = $userService;
        $this->productService       = $productService;
        $this->labourProductService = $labourProductResource;
        $this->jobSourceService     = $jobSourceService;
        $this->quoteService         = $quoteService;
        $this->jobService           = $jobService;
        $this->termsService         = $termsService;
        $this->selectListHelper     = $selectListHelper;
        $this->templateService      = $templateService;
        $this->bookingService       = $bookingService;
        $this->bookingTypeService   = $bookingTypeService;
        $this->quoteManager = $quoteManager;
        $this->accountManager = $accountManager;

        $this->middleware(['permission:quote.access']);
        $this->middleware(
            'permission:quote.access.add.quote', 
            ['only' => ['store', 'create']]
        );
        $this->middleware(
            'permission:quote.access.view.costing', 
            ['only' => ['edit']]
        );
        $this->middleware(
            'permission:quote.access.edit.screen.1|quote.access.edit.costing', 
            ['only' => ['update']]
        );
    }


    /**
     * Display quotes list page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $quote = $this->quoteManager->findLatest($request->user());

            if (!$quote) {
                return redirect()->route('admin.quotes.create');
            }

            return redirect()->route('admin.quotes.edit', $quote->id);
        } catch (\Exception $e) {
            logger()->error($e);
            abort(404);
        }
    }

    /**
     * Get the paginated quotes for table.
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getPaginatedQuotes(): JsonResource
    {
        $quotes = $this->quoteService->getPaginatedQuotesForTable(request()->all());

        return $quotes;
    }

    /**
     * Show the form for adding the quotation.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $quote = null;
            $selectedTemplates = (object)[];
            if (!empty(request()->get('quote_id'))) {
                $quote = $this->quoteService->findById(request()->get('quote_id'));
            }
            if (!empty(request()->get('templates'))) {
                $selectedTemplates = $this->templateService->getSelected(explode(',', request()->get('templates')));
            }

            $customers          = $this->selectListHelper->getAllCustomers();
            $products           = $this->selectListHelper->getAllProducts();
            $labourProducts     = $this->labourProductService->getAll();
            $jobSources         = $this->jobSourceService->all();
            $templates          = $this->selectListHelper->getAllTemplates();

            return view('admin.modules.quotes.create', compact('customers', 'products', 'labourProducts', 'jobSources', 'quote', 'templates', 'selectedTemplates'));
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    /**
     * Store the quotation.
     *
     * @param QuotesRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuotesRequest $request)
    {
        $inputData = $request->except(['labour', 'material']);
        try {
            $quote = $this->quoteService->createQuote($inputData);

            flash('Successfully added new quote.', 'success');
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);

            flash('Unable to add new quote.', 'error');

            return $this->sendError('Unable to add new quote.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($quote->toArray(), 'Successfully added new quote.');
    }

    /**
     * Edit the quote with quote id provided.
     *
     * @param $quoteId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($quoteId, Request $request)
    {
        $user = $request->user();
        try {
            $quote          = $this->quoteService->findById((int)$quoteId);

            throw_if(
                $quote->converted_to_job, 
                new ModelNotFoundException('Converted to job.')
            );

            $products       = $this->productService->getAll();
            $labourProducts = $this->labourProductService->getAll();
            $jobSources     = $this->jobSourceService->all();
            $customers      = $this->selectListHelper->getAllCustomers();
            $staffs         = $this->selectListHelper->getAllUsers();
            $templates      = $this->selectListHelper->getAllTemplates();
            $bookings       = $this->bookingService->getByJob($quote->quote_id);
            $bookingTypes   = $this->bookingTypeService->getAll();
            $site           = $quote->site;

            $previous = $this->quoteManager->findPrevious($user, $quoteId);
            $next     = $this->quoteManager->findNext($user, $quoteId);

            return view(
                'admin.modules.quotes.edit',
                compact('quote', 'products', 'labourProducts', 'jobSources', 'previous',
                    'next', 'customers', 'staffs', 'templates', 'bookings', 'bookingTypes', 'site')
            );

        } catch (ModelNotFoundException $exception) {
            return abort(404);
        }
    }

    /**
     * Update  quote with given quote id.
     *
     * @param QuotesRequest $request
     * @param               $quoteId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuotesRequest $request, $quoteId)
    {
        $updateData = $request->except(['labour', 'material', 'jobSource']);

        try {
            $this->quoteService->update($updateData, (int)$quoteId);
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);
            flash('Unable to update quote.', 'error');

            return $this->sendError('Unable to update quote.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated quote.');
    }

    /**
     * @param $quoteId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($quoteId)
    {
        try {
            $this->quoteService->delete((int)$quoteId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Quote not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Quote.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->route('admin.quotes.index');
    }

    /**
     * Converts quote to job.
     *
     * @param int     $quoteId
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function convertQuoteToJob($quoteId, Request $request)
    {
        $this->validate($request, [
            'job_id'            => 'required',
            'initiation_date'   => 'required',
            'invoice.net_value' => 'required',
            'invoice.date'      => 'required',
        ]);

        try {
            $quote       = $this->quoteService->findById((int)$quoteId);
            $existingJob = $quote->job;

            if ($existingJob) {
                return $this->sendSuccessResponse($existingJob->toArray(), 'Successfully updated quote to job.');
            }
            $quote['job_id']          = $request->get('job_id');
            $quote['initiation_date'] = $request->get('initiation_date');
            $quote['invoice']         = $request->get('invoice');
            $job                      = $this->jobService->createJobFromQuote($quote);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($job->toArray(), 'Successfully updated quote to job.');
    }
}
