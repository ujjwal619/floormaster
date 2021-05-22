<?php

namespace App\FMS\Shop\Actions;

use App\FMS\Shop\Manager;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateShop extends AdminController
{
    public function __invoke(
        Site $site, 
        Request $request,
        Manager $shopManager
    ) {
        try {
            $details = $request->all();
            throw_if(
                $shopManager->findWhere([
                    'site_id' => $site->id, 
                    'name' => $details['name']
                ]), 
                new \Exception('Shop already created with same name.')
            );

            if (!$shop = $site->shops()->create($request->all())) {
                abort('204', 'Could not create Shop.');
            }
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new Shop.', 'error');

            return $this->sendError('Unable to create new Shop.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Shop added successfully.');
    }
}
