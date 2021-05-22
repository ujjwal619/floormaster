<?php

class SalesStaffSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $sites = app(\App\FMS\Site\Models\Site::class)->get();
        foreach ($sites as $site) {
            $site->salesStaffs()->create([
                'name' => 'Sales Staff 1',
                'commission_calculation' => 3
            ]);
        }
    }
}
