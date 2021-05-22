<?php

namespace App\Domain\Admin\Controllers\InstallationComplaint;

use App\Domain\Admin\Requests\InstallationComplaint\InstallationComplaintRequest;
use App\Domain\Admin\Services\InstallationComplaint\InstallationComplaintService;
use App\Domain\Admin\Services\Jobs\JobService;
use App\FMS\InstallationComplaint\Manager as InstallationComplaintManager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class InstallationComplaintController
 * @package App\Domain\Admin\Controllers\InstallationComplaint
 */
class InstallationComplaintController extends AdminController
{
    /**
     * @var InstallationComplaintService
     */
    protected $complaintService;

    /**
     * @var SelectListHelper
     */
    protected $selectListHelper;

    /**
     * @var JobService
     */
    protected $jobService;

    protected $installationComplaintManager;

    /**
     * InstallationComplaintController constructor.
     * @param InstallationComplaintService $complaintService
     * @param SelectListHelper $selectListHelper
     * @param JobService $jobService
     */
    public function __construct(
        InstallationComplaintService $complaintService,
        SelectListHelper $selectListHelper,
        JobService $jobService,
        InstallationComplaintManager $installationComplaintManager
    ) {
        $this->complaintService = $complaintService;
        $this->selectListHelper = $selectListHelper;
        $this->jobService       = $jobService;
        $this->installationComplaintManager       = $installationComplaintManager;

        $this->middleware(['permission:customer.complaints']);
        $this->middleware(
            'permission:customer.complaints.edit.complaint', 
            ['only' => ['update']]
        );
        $this->middleware(
            'permission:customer.complaints.add.complaint', 
            ['only' => ['create', 'store']]
        );
        $this->middleware(
            'permission:customer.complaints.delete.complaint', 
            ['only' => ['destroy']]
        );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $installationComplaint = $this->installationComplaintManager->findLatest(request()->user());

            return redirect()->route('admin.installation-complaints.edit', $installationComplaint);
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('admin.installation-complaints.create');
        } catch (\Exception $e) {
            logger()->error($e);
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $jobId = (int) $request->get('job');
        $complaints = $this->complaintService->getAll();

        $job = new \stdClass();
        if ($jobId) {
            $job = $this->jobService->getWithSalesPerson($jobId);
        }

        $jobs = $this->selectListHelper->getAllJobs();
        return view('admin.modules.installation-complaint.create', compact(
            'jobs', 'job', 'complaints'
        ));
    }

    /**
     * @param InstallationComplaintRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InstallationComplaintRequest $request)
    {
        try {
            $this->complaintService->store($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new installation complaint.', 'error');

            return $this->sendError('Unable to create new installation complaint.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new installation complaint.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $installationComplaint = $this->complaintService->findById($id);
        $job = $this->jobService->getWithSalesPerson($installationComplaint->job_id);
        $jobs = $this->selectListHelper->getAllJobs();
        $complaints = $this->complaintService->getAll();

        return view('admin.modules.installation-complaint.edit', compact('jobs', 'job',
            'installationComplaint', 'complaints'));
    }

    /**
     * @param int $id
     * @param InstallationComplaintRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, InstallationComplaintRequest $request)
    {
        try {
            $this->complaintService->update($id, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update installation complaints.', 'error');

            return $this->sendError('Unable to update installation complaints.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated installation complaints.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->complaintService->delete($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Installation Complaint not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to delete installation complaint.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully deleted installation complaint.');
    }
}
