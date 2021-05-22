<?php

namespace App\Data\Repositories\Account;

use App\Data\Entities\Models\Account\Account;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

/**
 * Class AccountEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class AccountEloquentRepository extends BaseRepository implements AccountRepository
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * BookingEloquentRepository constructor.
     * @param Application $application
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Application $application, DatabaseManager $databaseManager)
    {
        parent::__construct($application);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }

    public function getByFamily(int $familyId, int $siteId)
    {
        return $this->model->where(['family' => $familyId, 'site_id' => $siteId])->get();
    }
}
