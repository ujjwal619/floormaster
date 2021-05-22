<?php

namespace App\Domain\Admin\Controllers\Account;

use App\Domain\Admin\Requests\Account\AccountRequest;
use App\Domain\Admin\Services\Account\AccountService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Response;

class AccountController extends AdminController
{
    private $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
        $this->middleware(['permission:account.chart']);
        $this->middleware(
            'permission:account.chart.add.to.chart', 
            ['only' => ['store']]
        );
        $this->middleware(
            'permission:account.chart.edit.chart', 
            ['only' => ['update']]
        );
    }

    public function index()
    {
        return view('admin.modules.accounts.index');
    }

    public function family(int $family, int $siteId)
    {
        $accounts = $this->service->getByFamily($family, $siteId);
        return ['data' => $accounts];
    }

    public function store(AccountRequest $request)
    {
        try {
            $this->service->store($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create account.', 'error');

            return $this->sendError('Unable to create account.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created account.');
    }

    public function update(int $id, AccountRequest $request)
    {
        try {
            $this->service->update($id, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update account.', 'error');

            return $this->sendError('Unable to update account.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated account.');
    }
}
