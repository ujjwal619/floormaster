<?php

namespace App\Console\Commands;

use App\Imports\SupplierProductStockImport;
use App\Imports\SuppliersImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class CopySuppliersDataFromXls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copytodb:suppliers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy suppliers data from xls to database.';

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
        Excel::import(new SupplierProductStockImport, 'fmsdata.xlsx');

        dump('Successful');
    }
}
