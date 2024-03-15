<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\EmployeeStatuses;

class EmployeeStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $active = new EmployeeStatuses();
        $active->employee_status = 'Active';
        $active->_uid = Str::uuid()->toString();
        $active->save();

        $inactive = new EmployeeStatuses();
        $inactive->employee_status = 'Inactive';
        $inactive->_uid = Str::uuid()->toString();
        $inactive->save();
    }
}
