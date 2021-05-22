<?php

namespace App\Domain\Admin\Controllers\Template;

use App\Data\Entities\Models\Template\Template;
use App\Domain\Admin\Requests\Template\TemplateRequest;
use App\Domain\Admin\Services\Product\LabourProductService;
use App\Domain\Admin\Services\Product\MaterialProductService;
use App\Domain\Admin\Services\Template\TemplateService;
use App\FMS\Product\Manager as ProductManager;
use App\Infrastructure\Helpers\SelectListHelper;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class TemplateController
 * @package App\Domain\Admin\Controllers\Template
 */
class TemplateController extends AdminController
{
    /**
     * @var TemplateService
     */
    private $templateService;

    /**
     * @var MaterialProductService
     */
    private $productService;

    /**
     * @var LabourProductService
     */
    private $labourProductService;

    private $selectListHelper;

    private $productManager;

    /**
     * TemplateController constructor.
     * @param TemplateService $templateService
     * @param MaterialProductService $productService
     * @param LabourProductService $labourProductService
     */
    public function __construct(
        TemplateService $templateService,
        MaterialProductService $productService,
        LabourProductService $labourProductService,
        SelectListHelper $selectListHelper,
        ProductManager $productManager
    ) {
        $this->templateService      = $templateService;
        $this->productService       = $productService;
        $this->labourProductService = $labourProductService;
        $this->selectListHelper = $selectListHelper;
        $this->productManager = $productManager;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $template = $this->templateService->findLatest();

            return redirect()->route('admin.templates.edit', $template);
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('admin.templates.create');
        } catch (\Exception $e) {
            logger()->error($e);
            abort(404);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $products       = $this->selectListHelper->getAllProducts();
            $labourProducts = $this->labourProductService->getAll();

            return view('admin.modules.template.create', compact('products', 'labourProducts'));
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TemplateRequest $request)
    {
        $inputData = $request->all();
        try {
            $this->templateService->createTemplate($inputData);

            flash('Successfully added new template.', 'success');
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);

            flash('Unable to add new template.', 'error');

            return $this->sendError('Unable to add new template.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully added new template.');
    }

    /**
     * @param Template $template
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Template $template)
    {
        try {
            $products       = $this->productManager->getBySite($template->site_id);
            $labourProducts = $this->labourProductService->getAll();

            $previous = $template->getPreviousLink($template->id);
            $next     = $template->getNextLink($template->id);

            return view('admin.modules.template.edit', compact('products', 'labourProducts', 'template', 'previous', 'next'));
        } catch (ModelNotFoundException $exception) {
            logger()->error($exception);
            abort(404);
        } catch (\Exception $exception) {
            logger()->error($exception);
            abort(500);
        }
    }

    /**
     * @param Request $request
     * @param int $templateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TemplateRequest $request, int $templateId)
    {
        try {
            $this->templateService->update($request->all(), $templateId);
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update template.', 'error');

            return $this->sendError('Unable to update template.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated template.');
    }

    /**
     * @param $templateId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $templateId)
    {
        try {
            $this->templateService->delete($templateId);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Template not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Template.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return redirect()->route('admin.templates.index');
    }
}
