<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Bpreadingstatus;
use Illuminate\Database\Seeder;

class BPReadingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new Bpreadingstatus();
        $status->_uid = Str::uuid(36);
        $status->status_name = 'Low Critical';
        $status->slug = 'low-critical';
        $status->save();

        $status = new Bpreadingstatus();
        $status->_uid = Str::uuid(36);
        $status->status_name = 'Low';
        $status->slug = 'low';
        $status->save();

        $status = new Bpreadingstatus();
        $status->_uid = Str::uuid(36);
        $status->status_name = 'Within Range';
        $status->slug = 'within-range';
        $status->save();

        $status = new Bpreadingstatus();
        $status->_uid = Str::uuid(36);
        $status->status_name = 'High';
        $status->slug = 'high';
        $status->save();

        $status = new Bpreadingstatus();
        $status->_uid = Str::uuid(36);
        $status->status_name = 'High Critical';
        $status->slug = 'high-critical';
        $status->save();
    }
}
