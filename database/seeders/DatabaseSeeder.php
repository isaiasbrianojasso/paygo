<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\API;
use App\Models\IP;
use App\Models\Payment;
use App\Models\Call;
use App\Models\Transaccion;
use App\Models\detalle_transaccion;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\importaUsuarios;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $api_key = Str::random(6);
        $api_token = Str::uuid();
        $uuid = Str::uuid();

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'HollyDev',
            'creditos' => 2000,
            'email' => 'gomezlopeznapoleon@gmail.com',
            'password' => 12345678,
            'telegram' => 142398483,
            'telefono' => 4445705494,
            'habilitado' => 1,
            'api_key' => $api_key,
            'api_token' => $api_token,
            'binance_address' => 'TN2bgYx4PcwMQeGqBDWu894CgHcwkfFJMa',
        ]);

        Payment::create([
            'id_user' => 1,
            'amount' => 10,
            'coin' => 'usdt',
            'transaction' => '5354d7b75b889a4ed9da159a87c6ae2c02656ac5e6f179d5737f0e63491d77ce',
            'status' => 'success',
            'insertTime' => 1742916334000,
            'completeTime' => 1742916340000,
        ]);






        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Binance check',
            'descripcion_servicio' => 'Servicio de check de Binance',
            'imagen' => '/img.jpg',
            'service' => 'binance_check',
            'costo' => 10,
            'fecha_inicio' => '2019-04-13 00:00:00',
            'fecha_final' => '2023-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);


        Transaccion::create([
            'id' => 1,
        ]);

        detalle_transaccion::create([
            'trx' => '1234567890',
            'status' => true,
            'monto' => 100.50,
            'cuenta_origen' => 'Banco A',
            'cuenta_destino' => 'Banco B',
            'acreditado' => true,
            'token_auth' => 'auth_token_123',
            'captura' => 'capture_data',
            'moneda' => 'USD',
            'id_transaccion' => 1, // Assuming this is the transaccion ID
            'user_id' => 1, // Assuming this is the transaccion ID

        ]);
        $this->call(importaUsuarios::class);


    }
}

