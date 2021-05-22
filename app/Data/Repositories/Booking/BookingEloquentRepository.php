<?php

namespace App\Data\Repositories\Booking;

use App\Constants\DBTable;
use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Booking\BookingType;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class BookingEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class BookingEloquentRepository extends BaseRepository implements BookingRepository
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
        return Booking::class;
    }

    /**
     * @param BookingType $bookingType
     * @param array $details
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(BookingType $bookingType, array $details)
    {
        // dd($bookingType, $details);
        return $bookingType->bookings()->create($details);
    }

    /**
     * Get the latest booking.
     * @return Booking
     * @throws ModelNotFoundException
     */
    public function getLatest(): Booking
    {
        $template = $this->model->latest()->first();
        if (!$template) {
            throw new ModelNotFoundException();
        }

        return $template;
    }

    /**
     * @param int|null $bookingType
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getAll(int $bookingType = null)
    {
        $bookings = $this->model->newQuery()
            ->join(DBTable::BOOKING_TYPES, DBTable::BOOKING_TYPES.'.id', DBTable::BOOKINGS.'.booking_type_id')
            ->leftJoin(DBTable::JOBS, DBTable::JOBS.'.job_id', DBTable::BOOKINGS.'.job_id')
            ->leftJoin(DBTable::QUOTES, DBTable::QUOTES.'.quote_id', DBTable::BOOKINGS.'.job_id')
            ->select(
                DBTable::BOOKINGS.'.id',
                DBTable::BOOKINGS.'.job_id',
                DBTable::BOOKINGS.'.date',
                DBTable::BOOKINGS.'.customer',
                DBTable::BOOKINGS.'.location',
                DBTable::BOOKINGS.'.phone',
                DBTable::BOOKINGS.'.note',
                DBTable::BOOKINGS.'.for',
                DBTable::BOOKINGS.'.estimated_time_of_arrival',
                DBTable::BOOKINGS.'.estimated_time_on_site',
                DBTable::BOOKINGS.'.numeric_column_headings',
                DBTable::BOOKINGS.'.text_column_heading',
                DBTable::BOOKINGS.'.booking_type_id',
                DBTable::BOOKING_TYPES.'.name as booking_type_name',
                DBTable::JOBS.'.id as related_job_id',
                DBTable::QUOTES.'.id as related_quote_id'
            );
        if ($bookingType) {
            $bookings->where(DBTable::BOOKINGS.'.booking_type_id', $bookingType);
        }

        return $bookings->get();
    }

    /**
     * @param string $jobId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByJob(string $jobId)
    {
        $bookings = $this->model->newQuery()
            ->join(DBTable::BOOKING_TYPES, DBTable::BOOKING_TYPES.'.id', DBTable::BOOKINGS.'.booking_type_id')
            ->where(DBTable::BOOKINGS.'.job_id', $jobId)
            ->select(
                DBTable::BOOKINGS.'.date as booking_date',
                DBTable::BOOKINGS.'.id as booking_id',
                DBTable::BOOKINGS.'.for as booking_for',
                DBTable::BOOKINGS.'.booking_type_id',
                DBTable::BOOKING_TYPES.'.name as booking_type'
            )
            ->get();

        return $bookings;
    }
}
