<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Booking\Booking;
use App\Data\Entities\Models\Contractor\PaymentsDue;
use App\Data\Entities\Models\InstallationComplaint\InstallationComplaint;
use App\Data\Entities\Models\Job\Invoice;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Job\JobMaterialSale;
use App\Data\Entities\Models\Job\Receipt;
use App\Data\Entities\Models\Product\MaterialProduct;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Entities\Models\Quote\QuoteMaterialSale;
use App\Data\Entities\Models\Stock\CurrentOrder;
use App\Data\Entities\Models\Stock\CurrentStock;
use App\Data\Entities\Models\Stock\DeliveryOrder;
use App\Data\Entities\Models\Stock\FutureStock;
use App\Data\Entities\Models\Stock\OrderReceipt;
use App\Data\Entities\Models\Stock\Stock;
use App\FMS\Account\Models\AccountTotal;
use App\FMS\Account\ValueObjects\AccountTypes;
use App\FMS\CashBook\Models\CashBook;
use App\FMS\CurrentOrder\Models\MarryInvoice;
use App\FMS\Invoice\Model\Expense;
use App\FMS\Job\Manager;
use App\FMS\Remittance\Models\Remittance;
use App\FMS\Remittance\Models\RemittanceItem;
use App\FMS\Stock\Models\Allocation;
use App\FMS\Stock\Models\AllocationDispatch;
use App\FMS\Stock\Models\BackOrder;
use App\FMS\Stock\Models\FutureStockReceiveGroup;
use App\FMS\Supplier\Models\Payable;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanAccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Account and GL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TransactionJournal::truncate();
        CashBook::truncate();
        Payable::truncate();
        Remittance::truncate();
        RemittanceItem::truncate();
        PaymentsDue::truncate();
        JobMaterialSale::truncate();
        MaterialProduct::truncate();
        OrderReceipt::truncate();
        Receipt::truncate();
        Expense::truncate();
        Invoice::truncate();
        Booking::truncate();
        InstallationComplaint::truncate();
        AllocationDispatch::truncate();
        MarryInvoice::truncate();
        AccountTotal::truncate();
        CurrentOrder::truncate();
        DeliveryOrder::truncate();
        FutureStockReceiveGroup::truncate();
        FutureStock::truncate();
        CurrentStock::truncate();
        Allocation::truncate();
        BackOrder::truncate();
        Stock::truncate();
        Job::truncate();
        Quote::truncate();
        QuoteMaterialSale::truncate();
        JobMaterialSale::truncate();
        DB::statement('TRUNCATE TABLE pivot_jobs_sales');

        $accounts = Account::where('type', AccountTypes::DETAIL)->get();
        $accounts->map(function (Account $account) {
            $account->fill([
                'opening_balance' => 0,
                'account_balance' => 0,
                'total_balance' => 0,
            ])->save();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        dump('Successful');
    }
}
