<?php

use App\FMS\Site\ValueObjects\SiteNames;

class SiteSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $sites = [
            SiteNames::CRONULLA_RETAIL,
            SiteNames::CRONULLA_COMMERCIAL,
            SiteNames::KOGARAH_CARPETS,
            SiteNames::SHIRE_CARPTES
        ];

        foreach ($sites as $site) {
            \App\FMS\Site\Models\Site::firstOrCreate([
                'name' => $site
            ]);
        }
    }
}
