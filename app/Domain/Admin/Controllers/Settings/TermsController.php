<?php

namespace App\Domain\Admin\Controllers\Settings;


use App\Domain\Admin\Requests\Settings\Terms\TermsRequest;
use App\Domain\Admin\Services\Settings\Terms\TermsService;
use App\FMS\Terms\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class TermsController
 * @package App\Domain\Admin\Controllers\Settings
 */
class TermsController extends AdminController
{
    /**
     * @var TermsService
     */
    protected $termsService;

    protected $termsManager;

    /**
     * TermsController constructor.
     * @param TermsService $termsService
     */
    public function __construct(TermsService $termsService, Manager $termsManager)
    {
        $this->termsService = $termsService;
        $this->termsManager = $termsManager;

        $this->middleware(['permission:terms.access']);
        $this->middleware(
            'permission:term.access.edit.terms', 
            ['only' => ['update']]
        );
        $this->middleware(
            'permission:term.access.add.term', 
            ['only' => ['store']]
        );
        $this->middleware(
            'permission:term.access.delete.term', 
            ['only' => ['destroy']]
        );
    }

    /**
     * Index page for the terms.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $term = $this->termsManager->findLatest($request->user());

            if (!$term) {
                return redirect()->route('admin.terms.create');
            }

            return redirect()->route('admin.terms.edit', $term->id);
        } catch (\Exception $e) {
            logger()->error($e);
            abort(404);
        }
    }

    /**
     * Get the paginated terms for the table.
     */
    public function getPaginatedTermsForTable()
    {
        return $this->termsService->getPaginatedTermsForTable(request()->all());
    }

    /**
     * Show the form to create new terms.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.modules.settings.create');
    }

    /**
     * @param TermsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TermsRequest $request)
    {
        try {
            $this->termsService->store($request->all());

            flash('Successfully added new term.', 'success');
        } catch (\Exception $exception) {
            logger()->error($exception);

            flash('Unable to add new term.', 'error');

            return $this->sendError('Unable to add new term.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added new term.');
    }

    /**
     * Destroy the terms and conditions.
     * @param  int $termId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($termId)
    {
        try {
            $this->termsService->delete((int)$termId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Term not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to delete Term.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Term deleted successfully!');
    }

    /**
     * Edit the term.
     * @param int $termId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($termId)
    {
        try {
            $term = $this->termsService->findById((int)$termId);

            return view('admin.modules.settings.terms.edit', compact('term'));
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
    }

    /**
     * Update the term.
     * @param TermsRequest     $request
     * @param              int $termId
     */
    public function update(TermsRequest $request, $termId)
    {
        try {
            $this->termsService->update($request->all(), (int) $termId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update term.', 'error');

            return $this->sendError('Unable to update term.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated term.');
    }
}
