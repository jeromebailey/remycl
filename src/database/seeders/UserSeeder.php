<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory()->count(10)->create();

        $jerome = new User();
        $jerome->first_name = 'Jerome';
        $jerome->last_name = 'Bailey';
        $jerome->email = 'jerome.bailey@oneivelabs.com';
        $jerome->_uid = Str::uuid(36);
        $jerome->email_verified_at = now();
        $jerome->password = bcrypt('3ntr3pr3n3urSh!t');
        $jerome->active = 1;
        $jerome->remember_token = Str::random(10);
        $jerome->created_at = now();
        $jerome->updated_at = now();
        $jerome->save();
    }
}
