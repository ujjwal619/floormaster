<?php

namespace App\Domain\Admin\Services\JobSource;

use App\Data\Entities\Models\JobSource\JobSource;
use App\Data\Repositories\JobSource\JobSourceRepository;
use App\Domain\Admin\Resources\JobSource\JobSourceResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class JobSourceService
 * @package App\Domain\Admin\Services\JobSource
 */
class JobSourceService
{
    /**
     * @var JobSourceRepository
     */
    protected $jobSourceRepository;

    /**
     * JobSourceService constructor.
     * @param JobSourceRepository $jobSourceRepository
     */
    public function __construct(JobSourceRepository $jobSourceRepository)
    {
        $this->jobSourceRepository = $jobSourceRepository;
    }

    /**
     * Returns the paginated modules for data table.
     *
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedJobSourcesForTable(array $filters): JsonResource
    {
        $modules = $this->jobSourceRepository->getPaginatedJobSourcesWith($filters);

        return JobSourceResource::collection($modules);
    }

    /**
     * Stores a module in database.
     *
     * @param array $inputData
     * @return JobSource
     * @throws \Exception
     */
    public function create(array $inputData): JobSource
    {
        return $this->jobSourceRepository->create($inputData);
    }

    /**
     * Finds a JobSource by its id.
     *
     * @param $id
     * @return JobSource
     */
    public function findById(string $id): JobSource
    {
        return $this->jobSourceRepository->find($id);
    }

    /**
     * Updates the JobSource.
     *
     * @param string $id
     * @param array  $updateData
     * @return JobSource
     */
    public function update(string $id, array $updateData): JobSource
    {
        return $this->jobSourceRepository->update($updateData, $id);
    }

    /**
     * Deletes a JobSource.
     *
     * @param string $id
     */
    public function delete(string $id)
    {
        $this->jobSourceRepository->delete($id);
    }

    /**
     * Get all job sources.
     * @return mixed
     */
    public function all()
    {
        return $this->jobSourceRepository->pluck('title', 'id');
    }
}
