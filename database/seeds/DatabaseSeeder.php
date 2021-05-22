<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SiteSeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);

        // TODO remove this while deploying for production
        
        if (env('APP_ENV') === 'production') exit();
        $this->call(JobSourceSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SalesStaffSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(TermSeeder::class);
        // $this->call(TemplateSeeder::class);
    }
}
