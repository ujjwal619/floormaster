<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'family' => \App\FMS\Account\ValueObjects\AccountFamilies::ASSETS,
                'name' => 'Assets 1',
                'type' => 2,
                'code' => '1000',
                'gst_applicable' => true,
                'opening_balance' => 300
            ],
            [
                'family' => \App\FMS\Account\ValueObjects\AccountFamilies::COST_OF_SALES,
                'name' => 'Assets 2',
                'type' => 2,
                'code' => '2000',
                'gst_applicable' => true,
                'opening_balance' => 200
            ],
            [
                'family' => \App\FMS\Account\ValueObjects\AccountFamilies::EXPENSES,
                'name' => 'Assets 3',
                'type' => 2,
                'code' => '3000',
                'gst_applicable' => true,
                'opening_balance' => 500
            ],
        ];
//        $site = app(\App\FMS\Site\Models\Site::class)->first();
        foreach ($accounts as $account) {
            \App\Data\Entities\Models\Account\Account::firstOrCreate($account);
        }
    }
}
