<?php

namespace App\FMS\User\Actions;

use App\FMS\User\Manager;
use App\FMS\User\Requests\UpdateUserRequest;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateUser extends AdminController
{
    public function __invoke(
        string $userId, 
        Manager $userManager, 
        UpdateUserRequest $request
    ) {
        if (!$user = $userManager->find($userId)) {
            abort(404, 'User not found.');
        }

        if ($userManager->update(
            $user, 
            $request->except(['id']), 
            $request->user()
        )) {
            return $this->sendSuccessResponse([], 'Successfully updated user.');
        }

        return $this->sendError('Could not update user.');
    }
}
