<?php

namespace Database\Seeders;

use App\Models\RPMService;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RPMServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bp = new RPMService();
        $bp->_uid = Str::uuid();
        $bp->rpm_service = 'Blood Pressure Monitoring';
        $bp->slug = 'bpm';
        $bp->save();

        $bp = new RPMService();
        $bp->_uid = Str::uuid();
        $bp->rpm_service = 'Blood Glucose Monitoring';
        $bp->slug = 'bgm';
        $bp->save();
    }
}
