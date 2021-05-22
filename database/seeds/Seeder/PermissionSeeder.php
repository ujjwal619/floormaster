<?php

use App\Data\Entities\Models\User\Permission;
use App\Data\Entities\Models\User\Role;
use Illuminate\Database\Seeder;

/**
 * Class PermissionSeeder
 */
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        foreach (config('Permissions') as $key => $permissions) {
            foreach ($permissions as $permission) {
                $permission['module'] = $key;
                $permission['guard_name'] = config('auth.defaults.guard');
                $permission['title'] = $permission['name'];
                Permission::firstOrCreate(['name' => $permission['name']], array_only($permission, ['name', 'title', 'module']));
            }
        }
        $this->attachPermissionsToRole();
    }

    private function attachPermissionsToRole()
    {
        $roles = Role::whereIn('name', ['admin', 'general'])->get();
        foreach ($roles as $role) {
            $method = 'get' . ucwords($role->name) . 'Permissions';
            $role->permissions()->sync($this->{$method}());
        }
    }

    public function getAdminPermissions($expressInIds = true)
    {
        $permissions = Permission::all();
        if ($expressInIds) {
            return $permissions->pluck('id', 'id')->toArray();
        }

        return $permissions->pluck('id', 'name')->toArray();
    }

    public function getGeneralPermissions($expressInIds = true)
    {
        
    }
}
