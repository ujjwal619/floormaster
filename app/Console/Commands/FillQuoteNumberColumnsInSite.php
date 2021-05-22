<?php

namespace App\Console\Commands;

use App\FMS\Site\Models\Site;
use App\FMS\Site\ValueObjects\SiteNames;
use Illuminate\Console\Command;

class FillQuoteNumberColumnsInSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fillQuoteNumberColumnsInSite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill quote number columns in site.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

     private $site;
    public function __construct(Site $site)
    {
        parent::__construct();
        $this->site = $site->newQuery();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cronullaRetail = app(Site::class)->where('name', SiteNames::CRONULLA_RETAIL)->first();
        $cronullaRetail->fill([
            'quote_number_from' => 100000,
            'quote_number_to' => 199999,
            'quote_prefix' => 'Q'
        ])->save();

        $cronullaCommercial = app(Site::class)->where('name', SiteNames::CRONULLA_COMMERCIAL)->first();
        $cronullaCommercial->fill([
            'quote_number_from' => 40000,
            'quote_number_to' => 99999,
            'quote_prefix' => ''
        ])->save();

        $kograhCarpet = app(Site::class)->where('name', SiteNames::KOGARAH_CARPETS)->first();
        $kograhCarpet->fill([
            'quote_number_from' => 300000,
            'quote_number_to' => 399999,
            'quote_prefix' => 'QN'
        ])->save();

        $shireCarpet = app(Site::class)->where('name', SiteNames::SHIRE_CARPTES)->first();
        $shireCarpet->fill([
            'quote_number_from' => 200000,
            'quote_number_to' => 299999,
            'quote_prefix' => 'QN'
        ])->save();

        dump('Successful');
    }
}
