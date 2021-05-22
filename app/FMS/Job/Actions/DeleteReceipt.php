<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Receipt;
use App\FMS\Job\Events\ReceiptDeleted;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteReceipt extends AdminController
{
    public function __construct()
    {
        $this->middleware('permission:job.access.delete.receipts');
    }

    public function __invoke(Request $request, Receipt $receipt)
    {
        try {
            $receipt = $receipt->fresh(['job.site']);

            $isSuperUser = $request->user()->hasRole('super_admin');
            $from = getDateRange($isSuperUser, 'start'); 
            $to = getDateRange($isSuperUser, 'end'); 

            $receipt1 = $receipt->newQuery()
                ->whereBetween('receipt_date', [$from, $to])
                ->where('id', $receipt->id)
                ->first();
            
            throw_if(!$receipt1, new Exception(
                'Receipts between date ' . $from . ' and ' . $to . ' can only be deleted'
            ));

            if (!$receipt1->delete()) {
                abort('204', 'Could not delete receipt.');
            }

            event(new ReceiptDeleted($receipt, $receipt->job));
        } catch(\Exception $exception) {
            return $this->sendError($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return $this->sendSuccessResponse([], 'Receipt deleted successfully.');
    }
}
