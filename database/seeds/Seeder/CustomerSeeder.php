<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = app(\App\FMS\Site\Models\Site::class)->get();

        foreach ($sites as $site) {
            $site->customers()->create([
                'title' => 'Mr',
                'firstname' => 'Manjul',
                'trading_name' => 'Sigdel',
            ]);
        }
    }
}
