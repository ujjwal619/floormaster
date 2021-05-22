<?php

namespace App\Domain\Admin\Services\InstallationComplaint;

use App\Data\Entities\Models\InstallationComplaint\InstallationComplaint;
use App\Data\Repositories\InstallationComplaint\InstallationComplaintRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class InstallationComplaintService
 * @package App\Domain\Admin\Services\InstallationComplaint
 */
class InstallationComplaintService
{
    /**
     * @var InstallationComplaintRepository
     */
    protected $repository;

    /**
     * InstallationComplaintService constructor.
     * @param InstallationComplaintRepository $repository
     */
    public function __construct(InstallationComplaintRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find the latest id of the installation complaint.
     * @return mixed
     */
    public function findLatest()
    {
        return $this->repository->getLatest();
    }

    /**
     * @param array $details
     * @return mixed
     */
    public function store(array $details)
    {
        return $this->repository->create($details);
    }

    /**
     * @param int $id
     * @param array $inputData
     * @return mixed
     */
    public function update(int $id, array $inputData)
    {
        return $this->repository->update($inputData, $id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Find complaint by its id.
     *
     * @param int $id
     *
     * @return InstallationComplaint
     */
    public function findById(int $id): InstallationComplaint
    {
        return $this->repository->find($id);
    }

    /**
     * @param int $jobId
     * @return Collection
     */
    public function getByJob(int $jobId): Collection
    {
        return $this->repository->getByJob($jobId);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->repository->with(['job'])->get();
    }
}
