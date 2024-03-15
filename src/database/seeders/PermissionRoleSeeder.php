<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('Seeding: PermissionRole table seeding!');
        $path = 'database/imports/permissions_roles.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Seeded: PermissionRole table seeded!');
    }
}
