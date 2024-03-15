<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tellihealth = new Manufacturer();
        $tellihealth->_uid = Str::uuid(36);
        $tellihealth->manufacturer_name = 'Telli Health';
        $tellihealth->abbreviation = 'tellihealth';
        $tellihealth->save();

        $bioland = new Manufacturer();
        $bioland->_uid = Str::uuid(36);
        $bioland->manufacturer_name = 'Bioland';
        $bioland->abbreviation = 'bioland';
        $bioland->save();
    }
}
