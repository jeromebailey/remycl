<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Contactclass;
use Illuminate\Database\Seeder;

class ContactclassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $class = new Contactclass();
        $class->_uid = Str::uuid();
        $class->contact_class = 'Primary';
        $class->created_at = now();
        $class->updated_at = now();
        $class->save();

        $class = new Contactclass();
        $class->_uid = Str::uuid();
        $class->contact_class = 'Secondary';
        $class->created_at = now();
        $class->updated_at = now();
        $class->save();

        $class = new Contactclass();
        $class->_uid = Str::uuid();
        $class->contact_class = 'Tertiary';
        $class->created_at = now();
        $class->updated_at = now();
        $class->save();
    }
}
