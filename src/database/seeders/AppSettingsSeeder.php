<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding: AppSettings table seeding!');
        $path = 'database/imports/app_settings.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Seeded: AppSettings table seeded!');
    }
}
