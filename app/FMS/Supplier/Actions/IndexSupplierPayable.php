<?php

namespace App\FMS\Supplier\Actions;

use App\FMS\Supplier\Queries\LatestSupplier;
use App\FMS\Supplier\Resources\SupplierResource;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexSupplierPayable extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:payables']);
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $payable = $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->where('user_sites.user_id', $user->id)
            ->join('supplier_payables', 'supplier_payables.site_id', 'sites.id')
            ->where('supplier_payables.is_paid', false)
            ->select(
                'supplier_payables.id as id'
            )
            ->orderBy('supplier_payables.updated_at', 'DESC')
            ->first();

        return $this->sendSuccessResponse($payable ? $payable->toArray() : []);
    }
}
