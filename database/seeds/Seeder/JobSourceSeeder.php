<?php

use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class JobSourceSeeder extends Seeder
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
            $site->sources()->firstOrCreate([
                'title' => 'Job Source 1',
                'name' => 'job-source-1'
            ]);
        }
    }
}
