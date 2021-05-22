<?php

namespace App\FMS\CostingTemplate\Actions;

use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class IndexTemplate extends AdminController
{
    use FilterSiteByUserTrait;
    
    public function __construct()
    {
        $this->middleware(['permission:job.template|job.template.view.costing']);
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();

        $template = $this->filterSiteByUser($user)
            ->join('tbl_templates', 'tbl_templates.site_id', 'sites.id')
            ->select(
                'tbl_templates.id as id'
            )
            ->orderBy('tbl_templates.updated_at', 'DESC')
            ->first();

        return $this->sendSuccessResponse($template ? $template->toArray() : []);
    }
}
