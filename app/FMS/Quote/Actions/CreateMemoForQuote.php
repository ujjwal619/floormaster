<?php

namespace App\FMS\Quote\Actions;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use App\FMS\Memo\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateMemoForQuote extends AdminController
{
    public function __invoke(
        Quote $quote, 
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

        if (!$memoManager->create($quote, $details)) {
            abort('204', 'Could not create memo for quote.');
        }

        return $this->sendSuccessResponse([], 'Successfully memo for quote.');
    }
}
