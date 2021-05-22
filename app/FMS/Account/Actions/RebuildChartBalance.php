<?php

namespace App\FMS\Account\Actions;

use App\Data\Entities\Models\Account\Account;
use App\FMS\Account\Manager as AccountManager;
use App\FMS\Account\Models\AccountTotal;
use App\FMS\Account\ValueObjects\AccountTotalType;
use App\FMS\Account\ValueObjects\AccountTypes;
use App\FMS\Site\Models\Site;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use App\StartUp\BaseClasses\Controller\AdminController;
use Carbon\Carbon;

class RebuildChartBalance extends AdminController
{
    public function __invoke(
        Site $site, 
        AccountTotal $accountTotal, 
        TransactionJournal $transactionJournal,
        AccountManager $accountManager
    ) {
        $accounts = $site->accounts()
            ->where('tbl_accounts.type', AccountTypes::DETAIL)
            ->get();

        $accounts->map(function (Account $account) use (
            $accountTotal, 
            $transactionJournal,
            $accountManager
        ) {
            $startOfFinancialYear = getFiscalYear();
            $endOfFinancialYear = getFiscalYear('end');

            $accountTotalThisFinancialYear = $accountTotal->newQuery()
                ->where('account_id', $account->id)
                ->where('site_id', $account->site_id)
                ->where('type', 'financial_year')
                ->where('date', $startOfFinancialYear)
                ->first();

            $transactionsFinancialYear = $transactionJournal->newQuery()
                ->where('site_id', $account->site_id)
                ->whereBetween('date', [$startOfFinancialYear, $endOfFinancialYear])
                ->where(function ($query) use ($account) {
                    return $query->where('debit_account_id', $account->id)
                        ->orWhere('credit_account_id', $account->id);
                })
                ->get();

            $totalAmountFinancialYear = $accountManager->totalFromTransactionJournal($transactionsFinancialYear, $account->id);
            
            if (!$accountTotalThisFinancialYear) {
                $accountTotalThisFinancialYear = $accountTotal->newQuery()->create([
                    'account_id' => $account->id,
                    'site_id' => $account->site_id,
                    'amount' => $totalAmountFinancialYear,
                    'type' => 'financial_year',
                    'date' => $startOfFinancialYear,
                    'from' => $startOfFinancialYear,
                    'to' => $endOfFinancialYear,
                ]);
            } else {
                $accountTotalThisFinancialYear->fill([
                    'amount' => $totalAmountFinancialYear
                ])->save();
            }

            for ($i=0; $i<12; $i++) {
                $startOfMonth = Carbon::parse(getFiscalYear())->month(7)->addMonth($i)->startOfMonth()->toDateString();
                $endOfMonth = Carbon::parse(getFiscalYear())->month(7)->addMonth($i)->endOfMonth()->toDateString();
                
                $accountTotalThisMonth = $accountTotal->newQuery()
                    ->where('account_id', $account->id)
                    ->where('site_id', $account->site_id)
                    ->where('type', 'monthly')
                    ->where('date', $startOfMonth)
                    ->first();

                $monthlyTransaction = $transactionJournal->newQuery()
                    ->where('site_id', $account->site_id)
                    ->whereBetween('date', [$startOfMonth, $endOfMonth])
                    ->where(function ($query) use ($account) {
                        return $query->where('debit_account_id', $account->id)
                            ->orWhere('credit_account_id', $account->id);
                    })
                    ->get();

                $totalAmountMonthly = $accountManager->totalFromTransactionJournal($monthlyTransaction, $account->id);

                if (!$accountTotalThisMonth) {
                    $accountTotalThisMonth = $accountTotal->newQuery()->create([
                        'account_id' => $account->id,
                        'site_id' => $account->site_id,
                        'amount' => $totalAmountMonthly,
                        'type' => 'monthly',
                        'date' => $startOfMonth,
                        'from' => $startOfMonth,
                        'to' => $endOfMonth,
                    ]);
                } else {
                    $accountTotalThisMonth->fill([
                        'amount' => $totalAmountMonthly
                    ])->save();
                }
            }

        });

        return $this->sendSuccessResponse([], 'Account successfully rebuild.');
    }
}
