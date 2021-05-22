<?php

namespace App\Data\Repositories\Template;

use App\Data\Entities\Models\Template\Template;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;

/**
 * Class TemplateEloquentRepository
 * @package App\Data\Repositories\Template
 */
class TemplateEloquentRepository extends BaseRepository implements TemplateRepository
{
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * TemplateEloquentRepository constructor.
     * @param Application $app
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Application $app, DatabaseManager $databaseManager)
    {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Template::class;
    }

    /**
     * Get the latest template.
     * @return Template
     * @throws ModelNotFoundException
     */
    public function getLatest(): Template
    {
        $template = $this->model->latest()->first();
        if (!$template) {
            throw new ModelNotFoundException();
        }

        return $template;
    }

    /**
     * Get selected templates
     * @param array $templates
     * @return Collection
     */
    public function getSelected(array $templates): Collection
    {
        return $this->model->whereIn('id', $templates)->get();
    }
}
