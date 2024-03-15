<?php

namespace Database\Seeders;

use App\Models\Contacttype;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ContacttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type = new Contacttype();
        $type->_uid = Str::uuid();
        $type->contact_type = 'Cell';
        $type->save();

        $type = new Contacttype();
        $type->_uid = Str::uuid();
        $type->contact_type = 'Home';
        $type->save();

        $type = new Contacttype();
        $type->_uid = Str::uuid();
        $type->contact_type = 'Work';
        $type->save();
    }
}
