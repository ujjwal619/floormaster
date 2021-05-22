<?php

namespace App\FMS\CostingTemplate;

use App\Data\Entities\Models\Template\Template;

class Manager
{
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function create(int $siteId, array $details)
    {
        $details['site_id' ] = $siteId;
        return $this->template->newInstance()->create($details);
    }

    public function update(Template $template, array $details)
    {
        return $template->fill($details)->save();
    }

    public function find(int $id)
    {
        return $this->template->find($id);
    }
}
