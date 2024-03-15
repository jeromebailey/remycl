<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $superAdmin = new Role();
        // $superAdmin->role_name = 'Super Administrator';
        // $superAdmin->slug = Str::slug('Super Administrator');
        // $superAdmin->save();

        // $administrator = new Role();
        // $administrator->role_name = 'Administrator';
        // $administrator->slug = Str::slug('Administrator');
        // $administrator->save();
        
        // $nurse = new Role();
        // $nurse->role_name = 'Nurse';
        // $nurse->slug = Str::slug('Nurse');
        // $nurse->save();

        // $physician = new Role();
        // $physician->role_name = 'Physician';
        // $physician->slug = Str::slug('Physician');
        // $physician->save();

        // $pharmacist = new Role();
        // $pharmacist->role_name = 'Pharmacist';
        // $pharmacist->slug = Str::slug('Pharmacist');
        // $pharmacist->save();

        // $patient = new Role();
        // $patient->role_name = 'Patient';
        // $patient->slug = Str::slug('Patient');
        // $patient->save();

        $this->command->info('Seeding: Roles table seeding!');
        $path = 'database/imports/roles.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Seeded: Roles table seeded!');

    }
}
