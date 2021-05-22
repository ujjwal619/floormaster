<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Booking\Booking;
use Illuminate\Console\Command;

class PutOpeningBalanceInAccountBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'putOpeningBalanceInAccountBalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put Opening Balance in account balance.';

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
        $accounts = Account::all();
        $accounts->map(function (Account $account) {
            $account->fill([
                'account_balance' => $account->opening_balance,
                'opening_balance' => 0,
                'total_balance' => $account->opening_balance
            ])->save();
        });

        dump('Successful');
    }
}
