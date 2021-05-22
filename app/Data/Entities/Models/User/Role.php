<?php

namespace App\Data\Entities\Models\User;

use Spatie\Permission\Models\Role as BaseRole;

/**
 * Class Role
 * @package App\Data\Entities\Models\User
 */
class Role extends BaseRole
{
    /**
     * The following fields are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'title', 'guard_name'];
}
