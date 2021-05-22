<?php

namespace App\Data\Repositories\Contractor;

use App\Data\Entities\Models\Contractor\Contractor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Container\Container as Application;

class ContractorEloquentRepository extends BaseRepository implements ContractorRepository
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
        return Contractor::class;
    }

    public function getLatest(): Contractor
    {
        $contractor = $this->model->latest()->first();
        if (!$contractor) {
            throw new ModelNotFoundException();
        }

        return $contractor;
    }
}
