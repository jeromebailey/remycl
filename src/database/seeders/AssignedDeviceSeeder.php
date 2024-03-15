<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Assigneddevice;
use Illuminate\Database\Seeder;

class AssignedDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $device = new Assigneddevice();
        $device->_uid = Str::uuid();
        $device->device_unique_id = '866901061284651';
        $device->patient_user_id = 101;
        $device->assigned_by_user_id = 101;
        $device->save();

        // $device = new Assigneddevice();
        // $device->_uid = Str::uuid();
        // $device->device_unique_id = '866901061284651';
        // $device->patient_user_id = 103;
        // $device->assigned_by_user_id = 101;
        // $device->save();
    }
}
