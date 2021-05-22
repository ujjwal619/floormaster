<?php

namespace App\Domain\Admin\Services\Contractor;

use App\Data\Entities\Models\Contractor\Contractor;
use App\Data\Repositories\Contractor\ContractorRepository;
use App\Domain\Admin\Services\Jobs\JobService;
use App\FMS\Contractor\Events\PayableCreated;
use Illuminate\Database\DatabaseManager;

class ContractorService
{
    private $repository;
    private $jobService;
    private $databaseManager;

    public function __construct(
        ContractorRepository $repository,
        JobService $jobService,
        DatabaseManager $databaseManager
    ) {
        $this->repository = $repository;
        $this->jobService = $jobService;
        $this->databaseManager = $databaseManager;
    }

    public function findLatest(): Contractor
    {
        return $this->repository->getLatest();
    }

    public function create(array $inputData): Contractor
    {
        return $this->repository->create($inputData);
    }

    public function update(array $inputData, int $templateId)
    {
        return $this->repository->update($inputData, $templateId);
    }

    public function delete(int $templateId)
    {
        return $this->repository->delete($templateId);
    }

    public function findByTfn($tfn)
    {
        return $this->repository->findByField('tfn', $tfn);
    }

    public function createPayment(int $contractorid, array $details)
    {
        return $this->databaseManager->transaction(function () use (
            $contractorid, 
            $details
        ) {
            try {
                $contractor = $this->repository->find($contractorid);

                $details['gst_amount'] = $details['amount'] * ($details['gst']/100);
                $details['site_id'] = $contractor->site_id;
                
                if($details['job_id']) {
                    if ($job = $this->jobService->findById($details['job_id'])) {
                        $details['client'] = $job->trading_name;
                        $details['project'] = $job->project;
                    }
                }
                
                $payable = $contractor->payments()->create($details);
                event(new PayableCreated($payable));
                $this->databaseManager->commit();

                return $payable;
            } catch (\Exception $exception) {
                
                $this->databaseManager->rollBack();
                dd($exception);
                return false;
            }
        });
    }
}
