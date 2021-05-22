<?php

namespace App\FMS\Job;

use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Job\Receipt;
use App\FMS\Invoice\Model\Expense;
use App\FMS\Site\Traits\FilterSiteByUserTrait;
use App\FMS\User\Models\User;

class Manager
{
    use FilterSiteByUserTrait;

    private $job;

    private $jobMaterialSale;

    private $receipt;

    public function __construct(
        Job $job, 
        JobMaterialSale $jobMaterialSale,
        Receipt $receipt
    ) {
        $this->job = $job;
        $this->jobMaterialSale = $jobMaterialSale;
        $this->receipt = $receipt;
    }

    public function find(int $id)
    {
        return $this->job->newQuery()->with(['customer'])->find($id);
    }

    public function findLatest(User $user)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->select(
                'tbl_jobs.id as id'
            )
            ->orderBy('tbl_jobs.updated_at', 'DESC')
            ->first();
    }

    public function findJobMaterialById(int $jobMaterialId)
    {
        return $this->jobMaterialSale->find($jobMaterialId);
    }

    public function findPrevious(User $user, int $jobId)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->where('tbl_jobs.id', '<', $jobId)
            ->select(
                'tbl_jobs.id as id'
            )
            ->max('tbl_jobs.id');
    }

    public function findNext(User $user, int $jobId)
    {
        return $this->filterSiteByUser($user)
            ->join('tbl_jobs', 'tbl_jobs.site_id', 'sites.id')
            ->where('tbl_jobs.id', '>', $jobId)
            ->select(
                'tbl_jobs.id as id'
            )
            ->min('tbl_jobs.id');
    }

    public function findReceipt(int $id)
    {
        return $this->receipt->find($id);
    }

    public function calculateJobTotal(Job $job)
    {
        $balance = $job->invoices->reduce(function ($carry1, Invoice $invoice) {
            return $carry1 + $invoice->balance_due;
        });

        $invoiceTotal = $job->invoices->reduce(function ($carry, $invoice) {
            return $invoice->amount + $carry;
        });

        $job->fill([
            'invoiced' => $invoiceTotal,
            'balance' => $balance - $job->unbilled_retention_amount
        ])->save();
    }
}
