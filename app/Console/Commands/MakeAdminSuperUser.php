<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Account\Account;
use App\Data\Entities\Models\Job\Job;
use App\FMS\Account\ValueObjects\AccountTypes;
use App\FMS\CashBook\Models\CashBook;
use App\FMS\Job\Manager;
use App\FMS\TransactionJournal\Models\TransactionJournal;
use App\FMS\TransactionJournal\ValueObjects\TransactionJournalType;
use App\FMS\User\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeAdminSuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makeAdminSuperUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Admin Super User.';

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
        $user = User::where('username', 'admin')->first();
        $user->assignRole('super_admin');

        dump('Successful');
    }
}
