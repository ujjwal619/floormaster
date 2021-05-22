<?php

namespace App\Domain\Admin\Controllers\Settings;

use App\Domain\Admin\Requests\Settings\SetupRequest;
use App\Domain\Admin\Services\JobSource\JobSourceService;
use App\Domain\Admin\Services\Settings\SetupService;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class SetupController extends AdminController
{
    private $service;

    private $jobSourceService;

    private $selectListHelper;

    public function __construct(SetupService $service, JobSourceService $jobSourceService, SelectListHelper $selectListHelper)
    {
        $this->service = $service;
        $this->jobSourceService = $jobSourceService;
        $this->selectListHelper = $selectListHelper;
    }

    public function index()
    {
        return view('admin.modules.setup.index');
    }

    public function save(SetupRequest $request)
    {
        try {
            $this->service->save($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update company info.', 'error');

            return $this->sendError('Unable to update company info.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated company info.');
    }
}
