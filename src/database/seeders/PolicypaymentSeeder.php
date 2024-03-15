<?php

namespace Database\Seeders;

use App\Models\Policypayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicypaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $noOfPayments = 50;
        Policypayment::factory()->count($noOfPayments)->create();
    }
}
