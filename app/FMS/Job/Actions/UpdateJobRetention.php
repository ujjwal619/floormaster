<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Job\Events\CalculateJobTotal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateJobRetention extends AdminController
{
    public function __invoke(Job $job, Request $request)
    {
        // $this->validate($request, [
        //     'date'           => 'required|date',
        //     'gst'           => 'required|numeric',
        //     'amount'         => 'required|numeric',
        //     'net_invoice'   => 'required|numeric'
        // ]);

        $details = $request->all();
        $isSaved = $job->fill([
            'unbilled_retention_amount' => array_get($details, 'unbilled_retention_amount', 0) ?? 0,
            'unbilled_retention_release_date' => array_get($details, 'unbilled_retention_release_date')
        ])->save();

        if (!$isSaved) {
            abort('204', 'Could not update job retention.');
        }

        event(new CalculateJobTotal($job));

        return $this->sendSuccessResponse([], 'Successfully updated Job Retention.');
    }
}
