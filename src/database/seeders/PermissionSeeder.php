<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('Seeding: Permissions table seeding!');
        $path = 'database/imports/permissions.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Seeded: Permissions table seeded!');
    }
}
