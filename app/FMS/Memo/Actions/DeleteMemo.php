<?php

namespace App\FMS\Memo\Actions;

use App\Data\Entities\Models\Memo\Memo;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class DeleteMemo extends AdminController
{
    public function __invoke(Memo $memo)
    {
        if (!$memo->delete()) {
            abort('204', 'Could not delete Memo.');
        }

        return $this->sendSuccessResponse([], 'Memo deleted successfully.');
    }
}
