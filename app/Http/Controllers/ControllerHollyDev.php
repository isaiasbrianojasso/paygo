<?php

namespace App\Http\Controllers;

use App\Models\transaccion;
use Illuminate\Http\Request;
use App\Services\CredentialService;
use App\Models\SMS;
use App\Models\IP;
use App\Models\AUTOREMOVE;
use App\Models\User;
use \App\Models\IntegrationCredential;
use App\Models\detalle_transaccion;
use App\Http\Controllers\ControllerAutoremove;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
            $hash = Str::uuid();
            $user->api_token = $hash;
            $user->save();
        } catch (Exception $e) {
            $user = Auth::user();
            $current = new Carbon();
            $texto = $user->email . $current;
            //$hash = hash('sha256', data: $texto);
            $hash = Str::uuid();
            $user->api_token = $hash;
            $user->save();
            return response()->json(['error' => 'Area Prohibida ... a poco creias que no pense en esto'], 500);
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

    public function binance_pay(Request $request)
    {

        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $secretKey = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";
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

        //$response = app('App\Http\Controllers\IntegrationCredentialController')->showDecrypted(Auth::user()->id);

        //$data = json_decode($response->getContent());

        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $secretKey = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";
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
            'X-MBX-APIKEY: ' . trim($apiKey) // OJO: trim() para quitar espacios
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
        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $secretKey = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";
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
        $integration = IntegrationCredential::where('user_id', Auth::id())->first();
        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $apiSecret = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";


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
        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $apiSecret = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";
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

    public function binance_id(Request $request)
    {




        $user = User::where('api_token', $request->api_key)->first();

        try {
            if (!$user) {
                return response()->json(['error' => 'Api key dont exist.'], 404);
            } else {


                $integration = IntegrationCredential::where('user_id', $user->id)->first();
                if (!$user) {
                    return response()->json(['error' => 'Api key don´t exist.'], 404);
                }
                // 2. Validar que tengamos el txId final
                /*
                if (!$request->has('orderId')) {
                    echo 'Falta el parámetro orderId';
                }*/

                $timestamp = round(microtime(true) * 1000);
                $params = [
                    'orderId' => $request->orderId,
                    'timestamp' => $timestamp
                ];

                $queryString = http_build_query($params);
                $signature = hash_hmac('sha256', $queryString, $integration->api_secret_enc);
                $url = "https://api.binance.com/sapi/v1/pay/transactions?$queryString&signature=$signature";

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-MBX-APIKEY: $integration->api_key_enc"]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($response, true);
                // 4. Buscar la transacción específica
                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $transaction) {
                        if ($transaction['orderId'] == $request->orderId) {
                            /*
                            $mensaje = "Binance ID: " . ($transaction['payerInfo']['binanceId'] ?? 'N/A') . " | " .
                                "Nombre: " . ($transaction['payerInfo']['name'] ?? 'No disponible') . " | " .
                                "Monto: " . ($transaction['amount'] ?? 0) . " " . ($transaction['currency'] ?? 'USDT') . " | " .
                                "Transaction ID: " . ($transaction['transactionId'] ?? 'N/A');
                                   dd($mensaje);                    return $mensaje;

                            */
                            $binance = [
                                'binance_id' => $transaction['payerInfo']['binanceId'] ?? 'N/A',
                                'nombre_binance' => $transaction['payerInfo']['name'] ?? 'No disponible',
                                'monto_binance' => $transaction['amount'] ?? 0,
                                'moneda_binance' => $transaction['currency'] ?? 'USDT',
                                'transaction_id_binance' => $transaction['transactionId'] ?? 'N/A'
                            ];

                            return $this->validatePayment($binance, $request, $user);
                            // Si lo vas a devolver como respuesta JSON en Laravel
                            //  return response()->json($mensaje, 200);
                        }
                    }
                }

                return response()->json('Dont exist any payment', 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Please setup first PayGo settings before to use'], 500);
        }
    }

    public function validatePayment($binance, $request, $user)
    {
        // Buscar si ya existe la transacción
        $detalleExistente = detalle_transaccion::where('transaction_id_binance', $binance['transaction_id_binance'])->first();

        if ($detalleExistente) {
            // Caso 1: Ya estaba aprobada
            if ($detalleExistente->status === 'aprobado') {
                return "hack 1";
            }

            // Caso 2: Estaba declinada, pero ahora el monto es correcto
            if ($detalleExistente->status === 'declinado' && $binance['monto_binance'] == $request->monto) {
                $detalleExistente->status = 'aprobado';
                $status = 'aprobado';
                $detalleExistente->save();
                $this->webhook($request, $detalleExistente, $user, $status);
                return "aprobado";
            }

            // Caso 3: Estaba declinada y sigue con monto incorrecto
            return "hack 3";
        }

        // Si no existe la transacción → crear nueva
        $transaccion = new transaccion();
        $transaccion->save();

        $detalle = new detalle_transaccion();
        $detalle->transaccion_id = $transaccion->id;
        $detalle->id_transaccion = $transaccion->id;
        $detalle->user_id = $user->id;
        $detalle->banco = 'Binance';
        $detalle->monto_binance = $binance['monto_binance'];
        $detalle->moneda = $binance['moneda_binance'];
        $detalle->binance_id = $binance['binance_id'];
        $detalle->nombre_binance = $binance['nombre_binance'];
        $detalle->transaction_id_binance = $binance['transaction_id_binance'];
        $detalle->identifier = $request->identifier;
        $detalle->servicio = $request->servicio;
        $detalle->hash_imagen = hash_file('sha256', $request->screenshot);
        // Aprobar solo si el monto es correcto
        if ($binance['monto_binance'] == $request->monto) {
            $detalle->status = 'aprobado';
            $status = 'aprobado';
            $this->webhook($request, $binance, $user, $status);
            $detalle->save();
            return "aprobado";
        } else {
            $detalle->status = 'declinado';
            $status = 'declinado';
            $detalle->save();
            $this->webhook($request, $binance, $user, $status);
            return "declinado";
        }
    }



    public function webhook($request, $binance, $user, $status)
    {
        $integration = IntegrationCredential::where('user_id', $user->id)->first();
        // Supongamos que $integration ya tiene el valor
        // Respuesta Webhook
        $data = [
            'monto' => ($binance['amount'] ?? 0),
            'moneda' => ($binance['currency'] ?? 'USDT'),
            'binance_id' => ($binance['payerInfo']['binanceId'] ?? 'N/A'),
            'nombre' => ($binance['payerInfo']['name'] ?? 'No disponible'),
            'transaction_id' => ($binance['transactionId'] ?? 'N/A'),
            'fecha' => now()->format('Y-m-d H:i:s'),
            'banco' => 'Binance',
            'identifier' => $request->identifier,
            'servicio' => $request->servicio,
            'status' => $status
        ];

        // Envía POST al webhook
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($integration->url_webhook, $data);

        // Verifica la respuesta
        if ($response->successful()) {
            //      echo 'Respuesta: ' . $response->body();
        } else {
            //    echo 'Error: ' . $response->status() . ' - ' . $response->body();
        }
        // Aquí puedes implementar la lógica para manejar el webhook
        // Por ejemplo, recibir datos de Binance y procesarlos
        //return response()->json(['message' => 'Webhook recibido correctamente'], 200);

    }



    public function processPayment(Request $request)
    {



        // Validación
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'concept' => 'string',
            'api_key' => 'string',
            'screenshot' => 'required|image|max:5120', // Máx 5MB
        ]);

        $apiKey = $request->input(key: 'api_key');

        $user = User::where('api_token', $apiKey)->first();
        ;

        $request->orderId = $validated['concept'];
        $request->monto = $validated['amount'];
        $request->screenshot = $validated['screenshot'];
        $resp = $this->binance_id($request);

        try {
            // Guardar la imagen temporalmente en el disco público
            $image = $request->file('screenshot');
            $imageName = 'temp_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('temp', $imageName, 'public');

            if (!$imagePath) {
                throw new \Exception('Error al guardar la imagen');
            }

            // Obtener la ruta absoluta de la imagen
            $absolutePath = storage_path('app/public/' . $imagePath);

            if (!file_exists($absolutePath)) {
                throw new \Exception('La imagen no se encontró en la ruta especificada');
            }

            // Enviar a Telegram
            $response = $this->sendToTelegram(
                $validated['amount'],
                $validated['email'],
                $validated['concept'],
                $absolutePath,
                $resp,
                $user,

            );

            // Eliminar la imagen temporal (ahora desde el disco público)
            Storage::disk('public')->delete($imagePath);
            if ($resp == "aprobado") {

                return response()->json([
                    'success' => true,
                    'message' => 'Pago Recibido'
                ], 200);

            } elseif ($resp == "declinado") {
                return response()->json([
                    'success' => false,
                    'message' => $resp
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $resp
                ], 200);
            }


            /*
            return response()->json([
                'success' => $response->successful(),
                'message' => $response->successful()
                    ? 'Comprobante enviado correctamente'
                    : 'Error al enviar el comprobante'
            ]);*/

        } catch (\Exception $e) {
            // Limpieza en caso de error
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return response()->json([
                'success' => false,
                'message' => $resp
            ], 500);
        }
    }

    private function sendToTelegram($amount, $email, $concept, $absolutePath, $resp, $user)
    {
        //   $botToken = "7285546131:AAGkupLGAY7ODqVol3K4tFRaetSbeyZcoZA";
        // $chatId = "142398483";

        $integration = IntegrationCredential::where('user_id', $user->id)->first();
        $botToken = $integration->token_telegram;
        $chatId = $integration->chat_id;

        // Verificar si el botToken y chatId están configurados
        if (!$botToken || !$chatId) {
            throw new \Exception('Bot token o chat ID no configurados');
        }
        // Determinar el estado
        if ($resp == 'aprobado') {
            $status = 'Aprobado';
        } elseif ($resp == 'declinado') {
            $status = 'Declinado no existe el pago o monto incorrecto';
        } else {
            $status = 'Pendiente o posiblemente ya habia sido Aprobado';
        }

        // Mensaje de texto
        $message = "💰 *Pago {$status}* 💰\n\n"
            . "➖ *Monto:* $" . number_format($amount, 2) . "\n"
            . "➖ *Email:* " . $email . "\n"
            . "➖ *transactionId:* " . $concept . "\n\n"
            . "⏱ *Fecha:* " . now()->format('d/m/Y H:i:s') . "\n"
            . "➖ *Estado:* " . $status . "\n\n";

        // Primero enviar el mensaje de texto
        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);

        // Luego enviar la imagen
        return Http::attach(
            'photo',
            file_get_contents($absolutePath),
            'comprobante.jpg'
        )->post("https://api.telegram.org/bot{$botToken}/sendPhoto", [
                    'chat_id' => $chatId,
                    'caption' => "Comprobante de pago - {$status}"
                ]);

    }
}
