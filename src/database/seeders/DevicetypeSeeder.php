<?php

namespace Database\Seeders;

use App\Models\Devicetype;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DevicetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $devicetype1 = new Devicetype();
        $devicetype1->_uid = Str::uuid(36);
        $devicetype1->device_type_name = 'Telli Health 4G Blood Pressure Monitor';
        $devicetype1->description = "Telli Health’s 4G Blood Pressure Monitor is the most accurate 4G cellular device on the market. This device combines the traditional testing kit (with multiple components) into one simple device with cellular-enabled 4G technology. This device is easy-to-use, durable, reliable, and accurate. In addition to the convenient design, the Telli Health 4G Blood Pressure Monitor ties into any software platform.";
        $devicetype1->manufacturer_id = 1;
        $devicetype1->minimum_stock_level = 10;
        $devicetype1->cost = 74.99;
        $devicetype1->model_no = 'BP01';
        $devicetype1->for_illness_id = 2;
        $devicetype1->save();

        $devicetype2 = new Devicetype();
        $devicetype2->_uid = Str::uuid(36);
        $devicetype2->device_type_name = 'Bioland 4G Blood Pressure Monitor';
        $devicetype2->description = "The Bioland 4G Blood Pressure Monitor is the lowest-cost 4G device on the market and one of the easiest to use. This device combines the traditional testing kit (with multiple components) into one simple device with cellular-enabled 4G technology. This device is easy-to-use, durable, reliable, and accurate. In addition to the convenient design, the Bioland 4G Blood Pressure Monitor ties into any software platform.";
        $devicetype2->manufacturer_id = 2;
        $devicetype2->minimum_stock_level = 10;
        $devicetype2->cost = 74.99;
        $devicetype2->model_no = '';
        $devicetype2->for_illness_id = 2;
        $devicetype2->save();

        $devicetype3 = new Devicetype();
        $devicetype3->_uid = Str::uuid(36);
        $devicetype3->device_type_name = 'Bioland 4G Blood Glucose Meter';
        $devicetype3->description = "The Bioland Blood Glucose Meter (Model: G-427B), exclusively offered by Telli Health, is the most cost-effective and easy-to-use 4G device on the market as it combines the traditional testing kit with multiple components into one meter that has cellular 4G technology. This device is durable, reliable, user-friendly, and accurate. Nothing is worse than getting a complicated glucose meter that has a hard-to-use interface. The ability to fit the G-427B easily into your pocket is also critical for folks who are always on the go. In addition to the convenient design, the 4G Glucose Meter ties into any software platform.";
        $devicetype3->manufacturer_id = 2;
        $devicetype3->minimum_stock_level = 10;
        $devicetype3->cost = 74.99;
        $devicetype3->model_no = 'G-427B';
        $devicetype3->for_illness_id = 1;
        $devicetype3->save();

        $devicetype4 = new Devicetype();
        $devicetype4->_uid = Str::uuid(36);
        $devicetype4->device_type_name = 'Bioland glucose meter strips';
        $devicetype4->description = "Diabetic test strips are compatible with Bioland (Model: G-427B) and are single-use only.";
        $devicetype4->manufacturer_id = 2;
        $devicetype4->minimum_stock_level = 10;
        $devicetype4->cost = 10.50;
        $devicetype4->model_no = '';
        $devicetype4->for_illness_id = 1;
        $devicetype4->save();

        // $devicetype5 = new Devicetype();
        // $devicetype5->_uid = Str::uuid(36);
        // $devicetype5->device_type_name = 'Lancets';
        // $devicetype5->description = "Lancets";
        // $devicetype5->manufacturer_id = 2;
        // $devicetype5->minimum_stock_level = 10;
        // $devicetype5->cost = 1.50;
        // $devicetype5->model_no = '';
        // $devicetype5->for_illness_id = 1;
        // $devicetype5->save();
    }
}
