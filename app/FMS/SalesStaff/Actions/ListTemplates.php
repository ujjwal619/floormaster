<?php

namespace App\FMS\SalesStaff\Actions;

use App\Data\Entities\Models\Template\Template;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListTemplates extends AdminController
{
    public function __invoke(Site $site, Request $request, Template $template)
    {
        $templates = $template->newQuery()
            ->where('site_id', $site->id)
            ->get()
            ->toArray();

        return $this->sendSuccessResponse($templates);
    }
}
