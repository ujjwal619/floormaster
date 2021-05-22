<?php

namespace App\FMS\Account;

use App\Data\Entities\Models\Account\Account;
use App\FMS\Account\Models\AccountTotal;
use App\FMS\Account\ValueObjects\AccountTotalType;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Manager
{
    private $account;
    private $accountTotal;
    private $transactionJournal;

    public function __construct(
        Account $account,
        AccountTotal $accountTotal,
        TransactionJournal $transactionJournal
    ) {
        $this->account = $account;
        $this->accountTotal = $accountTotal;
        $this->transactionJournal = $transactionJournal;
    }

    public function getAccountsBySite(int $siteId)
    {
        return $this->account->newQuery()->where('site_id', $siteId)->get()->toArray();
    }

    public function alterAmount(?int $accountId, float $amount, $operator = '+')
    {
        if ($accountId && $account = $this->account->find($accountId)) {
            $newAccountBalance = $account->account_balance + getAmountWithSign($amount, $operator);

            $account->fill([
                'account_balance' => $newAccountBalance,
                'total_balance' => $newAccountBalance + $account->opening_balance
            ])->save();

            $startOfMonth = getCurrentMonth();
            $endOfMonth = getCurrentMonth('end');

            $accountTotalThisMonth = $this->accountTotal->newQuery()
                ->where('account_id', $accountId)
                ->where('site_id', $account->site_id)
                ->where('type', 'monthly')
                ->where('date', $startOfMonth)
                ->first();

            if (!$accountTotalThisMonth) {
                $transactions = $this->transactionJournal
                    ->where('site_id', $account->site_id)
                    ->where('debit_account_id', $accountId, function($query) use ($accountId) {
                        $query->orWhere('credit_account_id', $accountId);
                    })
                    ->whereBetween('date', [$startOfMonth, $endOfMonth])
                    ->get();
                    
                $totalAmount = $this->totalFromTransactionJournal($transactions, $accountId);

                $accountTotalThisMonth = $this->accountTotal->newQuery()->create([
                    'account_id' => $accountId,
                    'site_id' => $account->site_id,
                    'amount' => $totalAmount,
                    'type' => AccountTotalType::MONTHLY,
                    'date' => $startOfMonth,
                    'from' => $startOfMonth,
                    'to' => $endOfMonth,
                ]);
            } else {
                $accountTotalThisMonth->fill([
                    'amount' => $accountTotalThisMonth->amount + getAmountWithSign($amount, $operator)
                ])->save();
            }

            $startOfFinancialYear = getFiscalYear();
            $endOfFinancialYear = getFiscalYear('end');

            $accountTotalThisFinancialYear = $this->accountTotal->newQuery()
                ->where('account_id', $accountId)
                ->where('site_id', $account->site_id)
                ->where('type', 'financial_year')
                ->where('date', $startOfFinancialYear)
                ->first();

            if (!$accountTotalThisFinancialYear) {
                $transactions = $this->transactionJournal
                    ->where('site_id', $account->site_id)
                    ->where('debit_account_id', $accountId, function($query) use ($accountId) {
                        $query->orWhere('credit_account_id', $accountId);
                    })
                    ->whereBetween('date', [$startOfFinancialYear, $endOfFinancialYear])
                    ->get();
                    
                $totalAmount = $this->totalFromTransactionJournal($transactions, $accountId);

                $accountTotalThisFinancialYear = $this->accountTotal->newQuery()->create([
                    'account_id' => $accountId,
                    'site_id' => $account->site_id,
                    'amount' => $totalAmount,
                    'type' => AccountTotalType::FINANCIAL_YEAR,
                    'date' => $startOfFinancialYear,
                    'from' => $startOfFinancialYear,
                    'to' => $endOfFinancialYear,
                ]);
            } else {
                $accountTotalThisFinancialYear->fill([
                    'amount' => $accountTotalThisFinancialYear->amount + getAmountWithSign($amount, $operator)
                ])->save();
            }
        }
    }

    public function totalFromTransactionJournal(Collection $transactions, $accountId)
    {
        return $transactions->reduce(function ($carry, $transactionJournal) use ($accountId) {
            $amount = $accountId === $transactionJournal->debit_account_id 
            ? getAmountWithSign($transactionJournal->debit_amount, $transactionJournal->debit_operator) : 
            getAmountWithSign($transactionJournal->credit_amount, $transactionJournal->credit_operator);
        
            return $amount + $carry;
        }, 0);
    }

}
