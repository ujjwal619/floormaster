<?php

namespace App\FMS\Job\Actions;

use App\Data\Entities\Models\Job\Job;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class SaveJobShop extends AdminController
{
    public function __invoke(Job $job, Request $request)
    {
        $job->fill(['shop_id' => $request->get('shop_id') ])->save();
        return $this->sendSuccessResponse([]);
    }
}
