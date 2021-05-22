<?php

namespace App\FMS\Memo\Actions;

use App\Data\Entities\Models\Memo\Memo;
use App\FMS\User\Models\User;
use App\StartUp\BaseClasses\Controller\AdminController;

class ListMemoByUser extends AdminController
{
    public function __invoke(User $user, Memo $memo)
    {
        $memos = $memo->newQuery()
            ->with(['user', 'reference'])
            ->where('user_id', $user->id)
            ->where('further_action', true)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($memos);
    }
}
