<?php

namespace App\FMS\Quote\Actions;

use App\Data\Entities\Models\Quote\Quote;
use App\Domain\Admin\Services\Jobs\JobService;;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateQuoteToJob extends AdminController
{
    public function __construct()
    {
        $this->middleware([
            'permission:quote.access.update.quote'
        ]);
    }

    public function __invoke(Quote $quote, Request $request, JobService $jobService)
    {
        $this->validate($request, [
            'initiation_date'   => 'required',
            'new_job_no' => 'unique:tbl_jobs,job_id|unique:tbl_quotes,quote_id'
        ]);

        try {
            $existingJob = $quote->job;

            if ($existingJob) {
                return $this->sendSuccessResponse($existingJob->toArray(), 'Successfully updated quote to job.');
            }

            $data = [];
            $data['job_id']          = $request->get('new_job_no') ?? $quote->quote_id;
            $data['initiation_date'] = $request->get('initiation_date');
            $data['recently_converted'] = true;

            $job = $jobService->createJobFromQuote($quote, $data);
            return $this->sendSuccessResponse($job->toArray());
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
