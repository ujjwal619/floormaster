<?php

namespace App\Data\Repositories\Template;

use App\Data\Entities\Models\Template\Template;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TemplateRepository
 * @package App\Data\Repositories\Template
 */
interface TemplateRepository extends RepositoryInterface
{
    /**
     * Get the latest template.
     * @return Template
     */
    public function getLatest(): Template;


    /**
     * Get Selected Templates
     * @param array $templates
     * @return Collection
     */
    public function getSelected(array $templates): Collection;
}
