<?php

namespace App\FMS\Contractor\Actions;

use App\Data\Entities\Models\Contractor\Contractor;
use App\Data\Entities\Models\Contractor\PaymentsDue;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class EditPaymentsDue extends AdminController
{
    public function __invoke(
        Contractor $contractor, 
        PaymentsDue $paymentsDue,
        Request $request
    ) {
        $details = $request->all();
        if(!$paymentsDue->fill([
            'client' => array_get($details, 'client'),
            'project' => array_get($details, 'project'),
            'details' => array_get($details, 'details'),
            'invoice_no' => array_get($details, 'invoice_no'),
        ])->save()) {
            abort('204', 'Could not update payments due.');
        }
        return $this->sendSuccessResponse([], 'Successfully updated payments due.');
    }
}
