<?php

namespace App\FMS\PostCode\Actions;

use App\FMS\PostCode\Models\AustraliaPostCode;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListAustraliaPostCodes extends AdminController
{
    public function __invoke(Request $request, AustraliaPostCode $australiaPostCode)
    {
        $user = $request->user();

        $for = $request->get('for');
        $state = $request->get('state');
        $suburb = $request->get('suburb');

        $australiaPostCodes = $australiaPostCode
            ->where('state', $state);
        
        if ($suburb) {
            $australiaPostCodes = $australiaPostCodes->where('suburb', $suburb);
        }

        // if ($for == 'suburb') {
        //     $australiaPostCodes = $australiaPostCodes->groupBy('suburb');
        // }

        $australiaPostCodes = $australiaPostCodes
            ->get();
            
        return $this->sendSuccessResponse($for == 'suburb' ? $australiaPostCodes->unique('suburb')->values()->toArray() : $australiaPostCodes->toArray());
    }
}
