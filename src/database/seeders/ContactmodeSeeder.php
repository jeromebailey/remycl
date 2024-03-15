<?php

namespace Database\Seeders;

use App\Models\Contactmode;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ContactmodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mode = new Contactmode();
        $mode->_uid = Str::uuid();
        $mode->contact_mode = 'Email';
        $mode->created_at = now();
        $mode->updated_at = now();
        $mode->save();

        $mode = new Contactmode();
        $mode->_uid = Str::uuid();
        $mode->contact_mode = 'Phone';
        $mode->created_at = now();
        $mode->updated_at = now();
        $mode->save();

    }
}
