<?php

namespace Database\Seeders;

use App\Models\Genders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $male = new Genders();
        $male->gender = 'Male';
        $male->_uid = Str::uuid()->toString();
        $male->save();

        $female = new Genders();
        $female->gender = 'Female';
        $female->_uid = Str::uuid()->toString();
        $female->save();
    }
}
