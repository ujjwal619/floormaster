<?php

use App\Data\Entities\Models\User\Role;
use App\Constants\DBTable;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleSeeder
 */
class RoleSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(DBTable::AUTH_ROLES_PERMISSIONS)->truncate();
        DB::table(DBTable::AUTH_USERS_PERMISSIONS)->truncate();
        // DB::table(DBTable::AUTH_USERS_ROLES)->truncate();
        DB::table(DBTable::AUTH_ROLES)->truncate();
        // DB::table(DBTable::AUTH_PERMISSIONS)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach (config('fms.roles') as $role) {
            $role['guard_name'] = config('auth.defaults.guard');
            Role::updateOrCreate(['name' => $role['name']], array_only($role, ['name']));
        }
    }
}
