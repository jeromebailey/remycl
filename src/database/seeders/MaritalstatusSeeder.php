<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Maritalstatus;
use Illuminate\Database\Seeder;

class MaritalstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status = new Maritalstatus();
        $status->marital_status = 'Married';
        $status->_uid = Str::uuid();
        $status->save();

        $status = new Maritalstatus();
        $status->marital_status = 'Divorced';
        $status->_uid = Str::uuid();
        $status->save();

        $status = new Maritalstatus();
        $status->marital_status = 'Single';
        $status->_uid = Str::uuid();
        $status->save();

        $status = new Maritalstatus();
        $status->marital_status = 'Widowed';
        $status->_uid = Str::uuid();
        $status->save();

        $status = new Maritalstatus();
        $status->marital_status = 'Separated';
        $status->_uid = Str::uuid();
        $status->save();
    }
}
