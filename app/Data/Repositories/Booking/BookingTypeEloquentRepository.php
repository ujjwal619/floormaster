<?php

namespace App\Data\Repositories\Booking;

use App\Data\Entities\Models\Booking\BookingType;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;

/**
 * Class BookingTypeEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class BookingTypeEloquentRepository extends BaseRepository implements BookingTypeRepository
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * BookingTypeEloquentRepository constructor.
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
        return BookingType::class;
    }

    /**
     * @return mixed
     */
    public function getLatest()
    {
        $template = $this->model->latest()->first();

        return $template;
    }
}
