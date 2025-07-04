<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SMS;
use App\Models\Sender;
use App\Models\API;
use App\Models\IP;
use App\Models\Autoremove;
use App\Models\Twilio;
use App\Models\Number;
use App\Models\Payment;
use App\Models\Call;

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
        $api_token  = Str::uuid();
        $uuid = Str::uuid();

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'HollyDev',
            'creditos' => 2000,
            'sms' => 100,
            'usados' => 10,
            'email' => 'gomezlopeznapoleon@gmail.com',
            'password' => 12345678,
            'telegram' => 142398483,
            'telefono' => 4445705494,
            'habilitado'=>1,
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

        SMS::create([
            'id_user' => 1,
            'msj' => 'esto es una prueba de sms',
            'number' => 524445705494,
            'sender' => 10,
            'api_id' => 1,
            'status' => 1,
            'sender_id' => 1,
            'costo' => 10,
            'sender_name' => '#1 Sender Mexico Long Code'

        ]);
        SMS::create([
            'id_user' => 1,
            'msj' => 'Hola',
            'number' => 554767589767,
            'sender' => 99,
            'api_id' => 1,
            'status' => 0,
            'sender_id' => 1,
            'costo' => 10,
            'sender_name' => '#1 Sender Mexico Long Code'
        ]);

        Sender::create([
            'sender_id' => 1,
            'sender_name' => '#1 Sender Mexico Long Code',
            'cobertura' => "Mexico",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 1,
        ]);
        Sender::create([
            'sender_id' => 2,
            'sender_name' => '#2 Sender Mexico Long Code',
            'cobertura' => "USA",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 2,
        ]);
        Sender::create([
            'sender_id' => 3,
            'sender_name' => '#3 Sender USA Long Code/ Mundial Long Code',
            'cobertura' => "USA",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 3,
        ]);

        Sender::create([
            'sender_id' => 4,
            'sender_name' => '#4 Sender USA',
            'cobertura' => "USA",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 4,
        ]);
        Sender::create([
            'sender_id' => 5,
            'sender_name' => '#5 Sender Mexico NO TELCEL',
            'cobertura' => "USA",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 5,
        ]);

        Sender::create([
            'sender_id' => 6,
            'sender_name' => '#6 Sender Mexico Telcel ext.777',
            'cobertura' => "USA",
            'sender' => "Apple",
            'costo' => 1,
            'api_id' => 6,
        ]);
        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '09cd15c9a8e8b37d63d49fee4d0ed86b',
            'parametro_1' => 'device', //device
            'valor_1' => 346955, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);

        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '09cd15c9a8e8b37d63d49fee4d0ed86b',
            'parametro_1' => 'device', //device
            'valor_1' => 345427, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);



        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '62d5cae262fd57a57e31f049584c86b5',
            'parametro_1' => 'device', //device
            'valor_1' => 339565, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);

        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '62d5cae262fd57a57e31f049584c86b5',
            'parametro_1' => 'device', //device
            'valor_1' => 339671, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);


        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '61b69a61b11cca581592799eb817ad2a',
            'parametro_1' => 'device', //device
            'valor_1' => 341066, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);
        API::create([
            'nombre' => 'semysms',
            'url' => "https://semysms.net/api/3/sms.php",
            'parametro_msg' => 'msg',
            'parametro_number' => 'phone',
            'parametro_token' => 'token',
            'valor_token' => '61b69a61b11cca581592799eb817ad2a',
            'parametro_1' => 'device', //device
            'valor_1' => 341068, //device
            'json' => 1, //device
            'parametro_success' => 'code',
            'valor_success' => 0,
            'borrado' => 0,
            'status' => 1,

        ]);
        IP::create([
            'ip' => '192.168.1.1',
            'user_id' => 1,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'imagen' => '/img.jpg',
            'costo' => 50,
            'service' => 'apple_remove',
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Autoremove Apple 1 y',
            'descripcion_servicio' => 'Autoremove apple API 1 slot',
            'service' => 'apple_remove',
            'imagen' => '/img.jpg',
            'costo' => 50,
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2027-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Google Maps',
            'descripcion_servicio' => 'Servicio de Mapas de google',
            'imagen' => '/img.jpg',
            'service' => 'google_maps',
            'costo' => 10,
            'fecha_inicio' => '2025-04-13 00:00:00',
            'fecha_final' => '2050-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Google Clean report',
            'descripcion_servicio' => 'Servicio de clean red report de google',
            'imagen' => '/img.jpg',
            'service' => 'google_clean',
            'costo' => 10,
            'fecha_inicio' => '2023-02-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Google check',
            'descripcion_servicio' => 'Servicio de check de google',
            'imagen' => '/img.jpg',
            'service' => 'google_check',
            'costo' => 10,
            'fecha_inicio' => '2020-04-13 00:00:00',
            'fecha_final' => '2026-04-13 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
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

        IP::create([
            'ip' => '192.168.1.45',
            'user_id' => 1,
            'nombre_servicio' => 'Calls',
            'descripcion_servicio' => 'Servicio de Calls',
            'imagen' => '/img.jpg',
            'service' => 'calls',
            'costo' => 10,
            'fecha_inicio' => '2025-05-01 00:00:00',
            'fecha_final' => '2025-05-23 00:00:00',
            'autorizado' => 1,
            'sync' => 0,
            'borrado' => 0,
        ]);
        Autoremove::create([
            'user_id' => 1,
            'apple_id' => 'radicalneoevo@me.com',
            'password' => 'Somepassword',

            'response' => 'Device Name: MacBook Pro de Jose
Modelo de dispositivo: MacBook Pro 13"
Mode: Removed successful
StatusLock: Clean',
            'status' => 'remove',
            'borrado' => 0,


        ]);

        Number::create([
            'twilio_id' => 1,
            'number' => '18393335970',
        ]);

        Call::create(['id_user' => 1, 'to' => '1234567890', 'recording_duration' => 60, 'cost' => 5.99, 'status' => 'completed',]);
        Call::create(['id_user' => 1, 'to' => '1234567890', 'recording_duration' => 60, 'cost' => 5.99, 'status' => 'completed',]);
        $this->call(importaUsuarios::class);


    }
}

