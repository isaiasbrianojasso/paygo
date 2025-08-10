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
        $apiKey = "4WSCBX6fmzS1HqrRsekiYnpGflKZW22LeROdwy0pHTxehldbvpSjuOereFsLYPo9";
        $secretKey = "CVvZ9ETpK8WQa1rYxd7ELflN1dWoR8oCUdjPcdfTg5SGtFQ4u8t2evwPW8S1XCZb";

        $url = 'https://bpay.binanceapi.com/binancepay/openapi/v2/order'; // o /v3/order

        // Datos del pedido (ajústalos a tu lógica y base de datos)
        $order = [
            "env" => ["terminalType" => "APP"],
            "merchantTradeNo" => uniqid('order_'), // tu propio identificador único
            "orderAmount" => 49.99,
            "currency" => "USDT",
            "goods" => [
                "goodsType" => "01",
                "goodsCategory" => "D000",
                "referenceGoodsId" => "PROD-123",
                "goodsName" => "Mi producto impresionante",
                "goodsDetail" => "Descripción breve del producto"
            ]
        ];

        // Creación automática de nonce
        $nonce = bin2hex(random_bytes(16));
        $timestamp = round(microtime(true) * 1000);
        $json = json_encode($order, JSON_UNESCAPED_SLASHES);

        // Firma del payload: timestamp + "\n" + nonce + "\n" + body + "\n"
        $payload = "{$timestamp}\n{$nonce}\n{$json}\n";
        $signature = strtoupper(hash_hmac('SHA512', $payload, $secretKey));

        // Configuramos headers necesarios
        $headers = [
            "Content-Type: application/json",
            "BinancePay-Timestamp: {$timestamp}",
            "BinancePay-Nonce: {$nonce}",
            "BinancePay-Certificate-SN: {$apiKey}",
            "BinancePay-Signature: {$signature}"
        ];

        // Enviamos petición
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            die('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        $resp = json_decode($response, true);
        if ($resp['status'] === 'SUCCESS') {
            $qrLink = $resp['data']['qrcodeLink'];
            $checkoutUrl = $resp['data']['checkoutUrl'] ?? null;
            echo "<h2>Escanea para pagar</h2>";
            echo "<img src='" . htmlspecialchars($qrLink) . "' alt='QR Binance Pay' width='300'>";
            if ($checkoutUrl)
                echo "<p>O paga directamente aquí: <a href='" . htmlspecialchars($checkoutUrl) . "' target='_blank'>Checkout</a></p>";
        } else {
            echo "<p>Error: " . htmlspecialchars($resp['errorMessage'] ?? 'Respuesta fallida') . "</p>";
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
