<?php

use App\FMS\User\Models\User;
use Illuminate\Database\Seeder;
use App\Constants\DBTable;
use Illuminate\Support\Facades\DB;

/**
 * Class UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionSeeder = app(PermissionSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(DBTable::AUTH_USERS)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::firstOrCreate([
            'username' => 'admin',
            'password' => 'password'
        ]);

        $user->assignRole('admin');
        $user->givePermissionTo($permissionSeeder->getAdminPermissions());

        $user->sites()->saveMany(\App\FMS\Site\Models\Site::all());
    }
}
