<?php

namespace App\Data\Repositories\Quote;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Repositories\Job\InvoiceRepository;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

class InvoiceEloquentRepository extends BaseRepository implements InvoiceRepository
{
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

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
        return Invoice::class;
    }
}
