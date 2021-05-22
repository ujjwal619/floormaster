<?php

namespace App\StartUp\Kernels;

use App\Console\Commands\CalculateInvoiceTotal;
use App\Console\Commands\CalculateJobTotal;
use App\Console\Commands\CleanAccount;
use App\Console\Commands\CleanBooking;
use App\Console\Commands\ConvertStringValuesToNumericInJobInvoiceTable;
use App\Console\Commands\CopyAustraliaStateCodeToDB;
use App\Console\Commands\CopySuppliersDataFromXls;
use App\Console\Commands\FillJobInitiatedDate;
use App\Console\Commands\FillQuoteNumberColumnsInSite;
use App\Console\Commands\FillSiteIdInProduct;
use App\Console\Commands\MakeAdminSuperUser;
use App\Console\Commands\PutOpeningBalanceInAccountBalance;
use App\Console\Commands\PutPreviousBookingsInSite;
use App\Console\Commands\PutUpcInMaterials;
use App\Console\Commands\RecalculateJobMaterialWithDelivery;
use App\Console\Commands\SaveCustomerDetailInJobTable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as BaseConsoleKernel;

/**
 * Class ConsoleKernel
 * @package App\StartUp\Kernels
 */
class ConsoleKernel extends BaseConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CopySuppliersDataFromXls::class,
        SaveCustomerDetailInJobTable::class,
        ConvertStringValuesToNumericInJobInvoiceTable::class,
        FillSiteIdInProduct::class,
        FillQuoteNumberColumnsInSite::class,
        CalculateJobTotal::class,
        PutPreviousBookingsInSite::class,
        RecalculateJobMaterialWithDelivery::class,
        FillJobInitiatedDate::class,
        CalculateInvoiceTotal::class,
        PutUpcInMaterials::class,
        PutOpeningBalanceInAccountBalance::class,
        CleanAccount::class,
        MakeAdminSuperUser::class,
        CopyAustraliaStateCodeToDB::class,
        CleanBooking::class
    ];

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(app_path('Domain/Console'));

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
