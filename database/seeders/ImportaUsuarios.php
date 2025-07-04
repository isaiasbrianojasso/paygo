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
            'sms' => 100,
            'usados' => 0,
            'email' => 'arthurcenter06@gmail.com',
            'password' => 1234,
            'api_key' => $api_key,
            'api_token' => $api_token,
            'binance_address' => '',
        ]);
        IP::create([
            'ip' => '84.200.154.125',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);

        IP::create([
            'ip' => '91.229.239.60',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '84.201.20.232',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '2a02:4780:b:651:0:c7a:e5c:1',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '2a02:4780:b::11',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '5.189.166.132',
            'user_id' => 2,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 500,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
    }
}
