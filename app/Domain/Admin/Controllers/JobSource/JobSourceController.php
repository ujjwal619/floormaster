<?php

namespace App\Domain\Admin\Controllers\JobSource;

use App\Domain\Admin\Requests\JobSource\JobSourceRequest;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * Class JobSourceController
 * @package App\Domain\Admin\Controllers\JobSource
 */
class JobSourceController extends AdminController
{
    /**
     * @var JobSourceService
     */
    protected $jobSourceService;

    /**
     * JobSourceController constructor.
     * @param JobSourceService $jobSourceService
     */
    public function __construct(JobSourceService $jobSourceService)
    {
        $this->jobSourceService = $jobSourceService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|JsonResource
     */
    public function getPaginatedJobSources()
    {
        return $this->jobSourceService->getPaginatedJobSourcesForTable(request()->all());
    }

    /**
     * List out the index page for the job source module.
     */
    public function index()
    {
        return view('admin.modules.job-source.index');
    }

    /**
     * Displays the form to create job source.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.modules.job-source.create');
    }

    /**
     * Create new role after validation.
     * @param JobSourceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(JobSourceRequest $request)
    {
        try {
            $this->jobSourceService->create($request->all());

            flash('Successfully added new job source.', 'success');
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new job source.', 'error');

            return $this->sendError('Unable to create new Job Source.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new job source.');
    }

    /**
     * Edit the job source.
     * @param $jobSourceId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($jobSourceId)
    {
        try {
            $jobSource = $this->jobSourceService->findById($jobSourceId);
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }

        return view('admin.modules.job-source.edit', compact('jobSource'));
    }

    /**
     * @param JobSourceRequest $request
     * @param                  $jobSourceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(JobSourceRequest $request, $jobSourceId)
    {
        try {
            $this->jobSourceService->update($jobSourceId,  $request->all());

            flash('Successfully updated Job Source.', 'success');
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Job Source not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('Unable to update Job Source.', 'error');

            return $this->sendError('Unable to update Permission.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated Job Source.');
    }

    /**
     * Deletes a Job Source.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $this->jobSourceService->delete($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Job Source not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to delete Job Source.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Job Source deleted successfully!');
    }
}
