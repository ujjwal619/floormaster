<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class TermSeeder extends Seeder
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
            $site->terms()->firstOrCreate([
                'name' => 'Term 1',
            ]);
        }
    }
}
