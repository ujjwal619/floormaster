<?php

namespace App\Data\Repositories\InstallationComplaint;

use App\Data\Entities\Models\InstallationComplaint\InstallationComplaint;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class InstallationComplaintEloquentRepository
 * @package App\Data\Repositories\Booking
 */
class InstallationComplaintEloquentRepository extends BaseRepository implements InstallationComplaintRepository
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * InstallationComplaintEloquentRepository constructor.
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
        return InstallationComplaint::class;
    }

    /**
     * Get the latest installation complaint.
     * @return InstallationComplaint
     * @throws ModelNotFoundException
     */
    public function getLatest(): InstallationComplaint
    {
        $template = $this->model->latest()->first();
        if (!$template) {
            throw new ModelNotFoundException();
        }

        return $template;
    }

    /**
     * @param string $jobId
     *
     * @return Collection
     */
    public function getByJob(string $jobId): Collection
    {
        $complaints = $this->model->newQuery()
            ->where('job_id', $jobId)
            ->select(
                'id', 'date_received', 'date_rectified', 'complaint'
            )
            ->get();

        return $complaints;
    }
}
