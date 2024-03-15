<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        RoleUser::factory()->count(10)->create();

        $myRole = new RoleUser();
        $myRole->user_id = 11;
        $myRole->role_id = 2;
        $myRole->save();
    }
}
