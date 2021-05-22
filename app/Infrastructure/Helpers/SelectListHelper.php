<?php

namespace App\Infrastructure\Helpers;

use App\Constants\AuthRoles;
use App\Data\Entities\Models\Product\Category;
use App\Data\Entities\Models\Customer\Customer;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Product\Product;
use App\Data\Entities\Models\Supplier\Supplier;
use App\Data\Entities\Models\Template\Template;
use App\Data\Entities\Models\User\Permission;
use App\Data\Entities\Models\User\Role;
use App\Data\Entities\Models\User\User;
use App\Domain\Admin\Services\Customers\CustomerService;
use App\Domain\Admin\Services\Users\UserService;
use Illuminate\Support\Collection;

/**
 * Class SelectListHelper
 * @package App\Infrastructure\Helpers
 */
class SelectListHelper
{
    /**
     * Returns all the roles.
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        return app(Role::class)->all();
    }

    /**
     * Returns all the permissions.
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return app(Permission::class)->all();
    }

    /**
     * Returns all the roles.
     *
     * @return Collection
     */
    public function getAllRolesNameAndIdForDropDown(): Collection
    {
        $allRoles =  app(Role::class)->pluck('name', 'id');
        unset($allRoles[array_search(AuthRoles::SUPER_ADMIN, $allRoles->toArray())]);

        return $allRoles;
    }

    /**
     * Returns all the product categories.
     *
     * @return array
     */
    public function getAllProductCategories(): array
    {
        $categories = app(Category::class)->select('id', 'title', 'site_id', 'inventory_account_id', 'cos_account_id')->with(['inventoryAccount', 'cosAccount', 'site'])->get()->toArray();

        return $categories;
    }

    /**
     * Returns all the customers.
     *
     * @return array
     */
    public function getAllCustomers(): array
    {
        $customers = app(CustomerService::class)->getAll()->map(function (Customer $customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->trading_name
            ];
        });

        return $customers->toArray();
    }

    /**
     * Returns all the users.
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        $users = app(UserService::class)->getAll()->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => sprintf('%s %s', optional($user->full_name)->first_name, optional($user->full_name)->last_name)
            ];
        });

        return $users->toArray();
    }

    /**
     * Return all the templates.
     *
     * @return array
     */
    public function getAllTemplates(): array
    {
        return app(Template::class)->select('id','name')->get()->toArray();
    }

    public function getAllSuppliers($siteId = 1): array
    {
        return app(Supplier::class)->select('id','trading_name')->where('site_id', $siteId)->get()->toArray();
    }

    /**
     * @param string $role
     * @return array
     */
    public function getUsersByRole(string $role): array
    {
        $users = app(User::class)->role($role)->get()->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => sprintf('%s %s', $user->full_name->first_name, $user->full_name->last_name)
            ];
        });

        return $users->toArray();
    }

    public function getAllJobs(): array
    {
        return app(Job::class)->select('id', 'job_id', 'customer_id', 'project')->with('customer')->get()->toArray();
    }

    public function getAllProducts()
    {
        return app(Product::class)->with(['supplier', 'productVariants'])->get();
    }
}
