<?php

namespace App\FMS\Shop\Actions;

use App\FMS\Shop\Manager as ShopManager;
use App\FMS\Shop\Models\Shop;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateShop extends AdminController
{
    public function __invoke(
        Shop $shop, 
        Request $request,
        ShopManager $shopManager
    ) {
        try {
            $details = $request->all();
            throw_if(
                $shopManager->findWhere([
                    'site_id' => $shop->site_id, 
                    'name' => $details['name'],
                    ['id' , '<>', $shop->id]
                ]), 
                new \Exception('Shop already created with same name.')
            );

            $shop->update($details);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update Shop.', 'error');

            return $this->sendError('Unable to update Shop.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse($shop->toArray(), 'Successfully updated Shop.');
    }
}
