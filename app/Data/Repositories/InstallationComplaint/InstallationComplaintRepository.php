<?php

namespace App\Data\Repositories\InstallationComplaint;

use App\Data\Entities\Models\InstallationComplaint\InstallationComplaint;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookingRepository
 * @package App\Data\Repositories\Booking
 */
interface InstallationComplaintRepository extends RepositoryInterface
{
    /**
     * Get the latest installation complaint.
     * @return InstallationComplaint
     */
    public function getLatest(): InstallationComplaint;

    /**
     * @param string $jobId
     *
     * @return Collection
     */
    public function getByJob(string $jobId): Collection;
}
