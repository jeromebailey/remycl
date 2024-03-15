<?php

namespace Database\Seeders;

use App\Models\EmployeeStatuses;
use App\Models\LeaveStatuses;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /*$this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);*/
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleUserSeeder::class,
            PolicytypeSeeder::class,
            PermissionRoleSeeder::class,
            ClientSeeder::class,
            UserClientSeeder::class,
            PolicypaymentSeeder::class,
            SmstemplateSeeder::class,
        ]);
    }
}
