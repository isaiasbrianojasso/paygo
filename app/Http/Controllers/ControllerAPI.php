<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function qr()
    {
        // Reemplaza esto con los valores reales de tu cuenta Binance Merchant
        $apiKey = "aa411g3tmuzsftbvubvoplvyslvuydypvpuxmkwfgpedowx2uipw6qo3zomhgs10";
        $secretKey = "zmufuv3yhz2pkvzohdkqjjtwldbn4mn6w32hubiucnc2okhgiouygmk4yrpex1ex";
        $url = 'https://bpay.binanceapi.com/binancepay/openapi/v2/order';

        // Generar merchantTradeNo válido (32 caracteres máximo)
        $merchantTradeNo = 'ORD' . time() . bin2hex(random_bytes(4)); // Ejemplo: ORD1691628896a1b2c3d4 (24 chars)

        // Validar merchantTradeNo
        if (empty($merchantTradeNo) || strlen($merchantTradeNo) > 32 || !preg_match('/^[a-zA-Z0-9_-]+$/', $merchantTradeNo)) {
            die('Error: merchantTradeNo no válido - debe contener máximo 32 caracteres alfanuméricos, guiones o guiones bajos');
        }

        // Datos del pedido
        $order = [
            "env" => [
                "terminalType" => "APP"
            ],
            "merchantTradeNo" => $merchantTradeNo,
            "orderAmount" => number_format(49.99, 2, '.', ''), // Formato decimal correcto
            "currency" => "USDT",
            "goods" => [
                "goodsType" => "01",
                "goodsCategory" => "D000",
                "referenceGoodsId" => "PROD-123",
                "goodsName" => "Mi producto impresionante",
                "goodsDetail" => "Descripción breve del producto"
            ]
        ];

        // Verificar que los datos sean válidos
        if ($order['orderAmount'] <= 0) {
            die('Error: El monto del pedido debe ser mayor que 0');
        }

        // Generación de nonce y timestamp
        $nonce = bin2hex(random_bytes(16));
        $timestamp = round(microtime(true) * 1000);

        // Convertir a JSON sin escapar slashes
        $json = json_encode($order, JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            die('Error al codificar los datos del pedido a JSON');
        }

        // Firma del payload
        $payload = "{$timestamp}\n{$nonce}\n{$json}\n";
        $signature = strtoupper(hash_hmac('SHA512', $payload, $secretKey));

        // Configurar headers
        $headers = [
            "Content-Type: application/json",
            "BinancePay-Timestamp: {$timestamp}",
            "BinancePay-Nonce: {$nonce}",
            "BinancePay-Certificate-SN: {$apiKey}",
            "BinancePay-Signature: {$signature}"
        ];

        // Enviar petición
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Recomendado para producción

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            die('Error en la conexión: ' . curl_error($ch));
        }
        curl_close($ch);

        // Procesar respuesta
        $resp = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error al decodificar la respuesta JSON: ' . json_last_error_msg());
        }

        if (isset($resp['status']) && $resp['status'] === 'SUCCESS') {
            $qrLink = $resp['data']['qrcodeLink'] ?? '';
            $checkoutUrl = $resp['data']['checkoutUrl'] ?? '';

            echo "<h2>Escanea para pagar</h2>";
            if (!empty($qrLink)) {
                echo "<img src='" . htmlspecialchars($qrLink, ENT_QUOTES) . "' alt='QR Binance Pay' width='300'>";
            }
            if (!empty($checkoutUrl)) {
                echo "<p>O paga directamente aquí: <a href='" . htmlspecialchars($checkoutUrl, ENT_QUOTES) . "' target='_blank'>Checkout</a></p>";
            }
        } else {
            $errorMsg = $resp['errorMessage'] ?? 'Error desconocido en la API';
            echo "<p>Error en la transacción: " . htmlspecialchars($errorMsg, ENT_QUOTES) . "</p>";

            // Debug: Mostrar detalles adicionales
            echo "<pre>Detalles de la respuesta: " . htmlspecialchars(print_r($resp, true), ENT_QUOTES) . "</pre>";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
