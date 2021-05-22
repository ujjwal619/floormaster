<?php

namespace App\Domain\Admin\Controllers\Dashboard;

use App\Data\Entities\Models\Memo\Memo;
use App\StartUp\BaseClasses\Controller\AdminController;

/**
 * Class DashboardController
 * @package App\Domain\Admin\Controllers\Dashboard
 */
class DashboardController extends AdminController
{
    /**
     * @var Memo
     */
    protected $memo;

    /**
     * DashboardController constructor.
     * @param Memo $memo
     */
    public function __construct(Memo $memo)
    {
        $this->memo = $memo;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $memosCount = $this->memo->where('user_id', currentUser()->id)->where('further_action' , 1)->count();

        return view('admin.modules.dashboard.index', compact('memosCount'));
    }
}
