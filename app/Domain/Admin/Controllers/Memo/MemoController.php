<?php

namespace App\Domain\Admin\Controllers\Memo;


use App\Data\Entities\Models\Memo\Memo;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

/**
 * Class MemoController
 * @package App\Domain\Admin\Controllers\Memo
 */
class MemoController extends AdminController
{
    /**
     * @var Memo
     */
    private $memo;

    /**
     * MemoController constructor.
     * @param Memo $memo
     */
    public function __construct(Memo $memo)
    {
        $this->memo = $memo;
    }

    public function index()
    {
        // $isAdmin = currentUser()->hasRole('super_admin');

        $isAdmin = true;
        if ($isAdmin) {
            $memos = $this->memo->all();
        } else {
            $memos = $this->memo->where('user_id', currentUser()->id);
        }

        return view('admin.modules.memos.index', compact('memos'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject'      => 'required|min:5',
            'details'      => 'required|min:5',
            'date'         => 'required|after:today',
            'user_id'      => 'required',
            'time'         => 'required',
            'type'         => 'required',
            'reference_id' => 'required',
        ]);

        try {
            $inputData                   = $request->all();
            $inputData['reference_type'] = $request->type === 'quote' ? 'App\Data\Entities\Models\Quote\Quote' : 'App\Data\Entities\Models\Job\Job';
            $this->memo->create($inputData);
        } catch (\Exception $exception) {
            logger()->error($exception);

            return $this->sendError('Unable to add memo.');
        }

        return $this->sendSuccessResponse([], 'Successfully added memo.');
    }
}
