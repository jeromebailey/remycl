<?php

namespace Database\Seeders;

use App\Models\Bpreading;
use Illuminate\Database\Seeder;

class BpReadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Bpreading::factory()->count(100)->create();
    }
}
