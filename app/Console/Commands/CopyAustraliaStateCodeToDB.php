<?php

namespace App\Console\Commands;

use App\Imports\AustraliaPostCodeImport;
use App\Imports\SupplierProductStockImport;
use App\Imports\SuppliersImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class CopyAustraliaStateCodeToDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copytodb:australiaStateCodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy australia state code data from xls to database.';

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
        Excel::import(new AustraliaPostCodeImport, 'australia_postcodes.csv');

        dump('Successful');
    }
}
