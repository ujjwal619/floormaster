<?php

namespace App\Domain\Admin\Controllers\Stock;

use App\Domain\Admin\Services\Stock\CurrentOrderService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurrentOrderController extends AdminController
{
    private $service;

    public function __construct(CurrentOrderService $service)
    {
        $this->service = $service;
        $this->middleware(['permission:orders']);
    }

    public function redirect()
    {
        return view('admin.modules.current-orders.index');
    }

    public function edit(int $id)
    {
        $currentOrder = $this->service->find($id);

        return view('admin.modules.current-orders.index', ['currentOrder' => $currentOrder]);

    }
}
