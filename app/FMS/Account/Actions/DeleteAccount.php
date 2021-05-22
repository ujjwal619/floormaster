<?php

namespace App\FMS\Account\Actions;

use App\Data\Entities\Models\Account\Account;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteAccount extends AdminController
{
    public function __invoke(Account $account)
    {
        if (!empty($account->reporters->toArray()) || !empty($account->cashBooks->toArray())) {
            return $this->sendError('Could not delete Account.');
        }
        if (!$account->delete()) {
            return $this->sendError('Could not delete Account.');
        }

        return $this->sendSuccessResponse([], 'Account deleted successfully.');
    }
}
