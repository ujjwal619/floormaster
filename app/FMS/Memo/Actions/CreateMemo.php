<?php

namespace App\FMS\Memo\Actions;

use App\Data\Entities\Models\Memo\Memo;
use App\FMS\Site\Manager as SiteManager;
use App\FMS\User\Manager as UserManager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class CreateMemo extends AdminController
{
    public function __invoke(
        Request $request, 
        Memo $memo,
        SiteManager $siteManager,
        UserManager $userManager  
    ) {
        $this->validate($request, [
            'subject'           => 'required',
            'details'           => 'required|min:5',
            'date'              => 'required|date',
            'user_id'           => 'required',
            'time'              => 'required|date_format:H:i',
            'further_action'    => 'required',
            'site_id'           => 'required',
        ]);

        $details = $request->all();
        
        $me = $request->user();
        $user = $request->user();
        $isUsersSite = $siteManager->isUserSite($user, $request->get('site_id'));
        $isMySite = $siteManager->isUserSite($me, $request->get('site_id'));

        if (!$isMySite || !$isUsersSite) {
            abort('401', 'Unauthorized Site.');
        }
        
        if (!$memo->fill($details)->save()) {
            abort('204', 'Could not create Memo.');
        }

        return $this->sendSuccessResponse([], 'Memo created successfully.');
    }
}
