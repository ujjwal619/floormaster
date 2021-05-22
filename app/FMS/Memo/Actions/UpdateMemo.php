<?php

namespace App\FMS\Memo\Actions;

use App\Data\Entities\Models\Memo\Memo;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateMemo extends AdminController
{
    public function __invoke(Request $request, Memo $memo)
    {
        $this->validate($request, [
            'subject'      => 'required|min:5',
            'details'         => 'required|min:5',
            'user_id'      => 'required',
            'further_action' => 'required',
        ]);

        $details = $request->all();
        
        if (!$memo->fill([
            'subject' => $details['subject'],
            'details' => $details['details'],
            'user_id' => $details['user_id'],
            'further_action' => $details['further_action'],
        ])->save()) {
            abort('204', 'Could not update Memo.');
        }

        return $this->sendSuccessResponse([], 'Memo updated successfully.');
    }
}
