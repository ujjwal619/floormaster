<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Memo\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateMemoForJob extends AdminController
{
    public function __invoke(
        Job $job, 
        Request $request,
        Manager $memoManager
    ) {

        $this->validate($request, [
            'subject'           => 'required',
            'details'           => 'required|min:5',
            'date'              => 'required|date',
            'user_id'           => 'required',
            'time'              => 'required|date_format:H:i',
            'further_action'    => 'required',
        ]);

        $details = $request->all();

        if (!$memoManager->create($job, $details)) {
            abort('204', 'Could not create memo for job.');
        }

        return $this->sendSuccessResponse([], 'Successfully memo for job.');
    }
}
