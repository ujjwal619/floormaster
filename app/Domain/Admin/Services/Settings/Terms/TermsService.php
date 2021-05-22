<?php

namespace App\Domain\Admin\Services\Settings\Terms;

use App\Data\Entities\Models\Terms\TermsAndCondition;
use App\Data\Repositories\Settings\Terms\TermsRepository;
use App\Domain\Admin\Resources\Settings\Terms\TermsResource;

/**
 * Class TermsService
 * @package App\Domain\Admin\Services\Settings\Terms
 */
class TermsService
{
    /**
     * @var TermsRepository
     */
    protected $termsRepository;

    public function __construct(TermsRepository $termsRepository)
    {
        $this->termsRepository = $termsRepository;
    }

    /**
     * @param array $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPaginatedTermsForTable(array $filters)
    {
        $data = $this->termsRepository->getPaginatedTermsWith($filters);

        return TermsResource::collection($data);
    }

    /**
     * Store the terms to database.
     * @param array $inputData
     * @return TermsAndCondition
     */
    public function store(array $inputData): TermsAndCondition
    {
        return $this->termsRepository->create($inputData);
    }

    /**
     * Delete the term.
     * @param int $termId
     * @return int
     */
    public function delete(int $termId): int
    {
        return $this->termsRepository->delete($termId);
    }

    /**
     * Find the term when term id is provided.
     * @param int $termId
     * @return TermsAndCondition
     */
    public function findById(int $termId): TermsAndCondition
    {
        return $this->termsRepository->find($termId);
    }

    /**
     * Update the terms.
     * @param array $updateData
     * @param int   $termId
     * @return TermsAndCondition
     */
    public function update(array $updateData, int $termId): TermsAndCondition
    {
        return $this->termsRepository->update($updateData, $termId);
    }

    /**
     * Get all terms.
     * @return mixed
     */
    public function all()
    {
        return $this->termsRepository->all();
    }
}
