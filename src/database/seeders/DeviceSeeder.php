<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Seeding: Devices table seeding!');
        $path = 'database/imports/devices.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Seeded: Devices table seeded!');
        //
        // $device1 = new Device();
        // $device1->_uid = Str::uuid(36);
        // $device1->device_type_id = 1;
        // $device1->imei = 1;
        // $device1->save();

        // $device2 = new Device();
        // $device2->_uid = Str::uuid(36);
        // $device2->device_type_id = 2;
        // $device2->imei = 2;
        // $device2->save();

        // $device3 = new Device();
        // $device3->_uid = Str::uuid(36);
        // $device3->device_type_id = 3;
        // $device3->imei = 2;
        // $device3->save();

        // $device4 = new Device();
        // $device4->_uid = Str::uuid(36);
        // $device4->device_type_id = 4;
        // $device4->imei = 2;
        // $device4->save();

        // $device5 = new Device();
        // $device5->_uid = Str::uuid(36);
        // $device5->device_type_id = 5;
        // $device5->imei = 2;
        // $device5->save();
    }
}
