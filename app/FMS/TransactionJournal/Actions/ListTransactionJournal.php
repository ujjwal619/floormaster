<?php

namespace App\FMS\TransactionJournal\Actions;

use App\FMS\Site\Models\Site;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class ListTransactionJournal extends AdminController
{
    public function __invoke(
        Site $site, 
        Request $request,
        TransactionJournalType $transactionJournalType
    ) {
        $transactionType = $request->get('type');
        $from = $request->get('from');
        $to = $request->get('to');
        $journals = $site->transactionJournals()
            ->when(collect($transactionJournalType->all())->contains($transactionType), function($query) use ($transactionType) {
                $query->where('transaction_type', $transactionType);
            })
            ->whereBetween('date', [$from, $to])
            ->with(['debitAccount', 'creditAccount', 'job.site'])
            ->latest()
            ->get();

        return $this->sendSuccessResponse($journals->toArray());
    }
}
