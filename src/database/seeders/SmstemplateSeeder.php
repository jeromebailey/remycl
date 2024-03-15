<?php

namespace Database\Seeders;

use App\Models\Smstemplate;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SmstemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $template = new Smstemplate();
        $template->_uid = Str::uuid();
        $template->template_title = 'Policy Expiring';
        $template->slug = 'policy-expiring';
        $template->template_body = 'Hi [first_name],

        Your [policy_type] policy with No. [policy_no] will expire on [expiry_date].';
        $template->save();
    }
}
