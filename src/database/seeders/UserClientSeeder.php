<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\UserClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $clients = Client::all();

        $clients->each(function ($client) use ($users) {
            DB::table('user_clients')->insert([
                'user_id' => $users->random()->id,
                'client_id' => $client->id,
            ]);
        });
    }
}
