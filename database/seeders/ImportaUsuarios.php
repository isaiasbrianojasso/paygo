<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\IP;

use Illuminate\Support\Str;

class ImportaUsuarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $api_key = Str::random(6);
        $api_token = Str::random(6);

        // User::factory(10)->create();

        User::create([
            'name' => 'Arthur',
            'creditos' => 0,
            'email' => 'arthurcenter06@gmail.com',
            'password' => 1234,
            'api_key' => $api_key,
            'api_token' => $api_token,
            'binance_address' => '',
        ]);


    }
}
