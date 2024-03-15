<?php

namespace Database\Seeders;

use App\Models\Personaldetail;
use Illuminate\Database\Seeder;

class PersonaldetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Personaldetail::factory()->count(100)->create();
    }
}
