<?php

namespace Database\Seeders;

use App\Models\Policytype;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PolicytypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $policy = new Policytype();
        $policy->_uid = Str::uuid();
        $policy->policy_type = 'Auto';
        $policy->slug = 'auto';
        $policy->save();

        $policy = new Policytype();
        $policy->_uid = Str::uuid();
        $policy->policy_type = 'Life';
        $policy->slug = 'life';
        $policy->save();

        $policy = new Policytype();
        $policy->_uid = Str::uuid();
        $policy->policy_type = 'Health';
        $policy->slug = 'health';
        $policy->save();

        $policy = new Policytype();
        $policy->_uid = Str::uuid();
        $policy->policy_type = 'Home';
        $policy->slug = 'home';
        $policy->save();
    }
}
