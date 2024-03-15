<?php

namespace Database\Seeders;

use App\Models\Devicestock;
use Illuminate\Database\Seeder;

class DeviceStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $numberOfRecords = 5;
        // Deviceinventory::factory($numberOfRecords)->create();

        for ($deviceId = 1; $deviceId < 5; $deviceId++) {
            Devicestock::factory()->create([
                'device_type_id' => $deviceId,
            ]);
        }
    }
}
