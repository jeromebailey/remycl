<?php

namespace Database\Seeders;

use App\Models\Illness;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class IllnessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $diabetes = new Illness();
        $diabetes->_uid = Str::uuid(36);
        $diabetes->illness = 'Diabetes';
        $diabetes->abbreviation = 'Diabetes';
        $diabetes->save();

        $hypertention = new Illness();
        $hypertention->_uid = Str::uuid(36);
        $hypertention->illness = 'Hypertension';
        $hypertention->abbreviation = 'Hypertension';
        $hypertention->save();
    }
}
