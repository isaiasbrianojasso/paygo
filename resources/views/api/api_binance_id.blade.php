@include('layouts.header')

@php
    $url = url('/');
    $apiToken = Auth::user()->api_token;
@endphp

<div id="content" class="app-content">
    <div class="panel">
        <div class="text-white bg-orange-700 panel-heading strong">Payment API Example paygo.lat</div>
    </div>

    <div class="border-0 card">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('assets/img/paygo.png') }}" class="ml-auto mr-auto "width="20%" alt="Paygo Logo" class="img-fluid">
        </div>
        <div class="mt-3 mb-3 row">
            <div class="mx-auto col-10">
                <h5 class="font-mono text-orange-600 usoAPI" >
                    API Endpoint Example
                </h5>
            </div>
        </div>

        <div class="mt-3 mb-5 row">
            <div class="mx-auto col-10">
                <div class="apiResponse alert alert-secondary">
                    <strong>Request:</strong>
                    <pre class="mb-0 text-primary">GET {{ $url }}/binance_id?api_key={{ $apiToken }}&orderId=1234567890&identifier=Test%20Transaction&servicio=agregar_creditos&monto=1234</pre>

                    <strong class="mt-3">Response:</strong>
                    <pre class="mb-0 text-success">aprobado</pre>
                    <pre class="mb-0 text-warning">declinado</pre>
                    <pre class="mb-0 text-danger">hack</pre>

                </div>
            </div>
        </div>

        <div class="mt-3 mb-3 row">
            <div class="mx-auto col-10">
                <h5 class="font-mono text-orange-600">
                    PHP Implementation Example:
                </h5>
                <pre class="bg-light p-3 rounded">
$apiUrl = "{{ $url }}/binance_id";
$apiKey = "{{ $apiToken }}";

$params = [
    'api_key' => $apiKey,
    'orderId' => '1234567890',
    'identifier' => 'Test Transaction',
    'servicio' => 'agregar_creditos',
    'monto' => 1234
];

$queryString = http_build_query($params);
$requestUrl = $apiUrl . '?' . $queryString;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);

// For development only - remove in production
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error = curl_error($ch);
    // Handle error
}

curl_close($ch);

// Process response
$result = json_decode($response, true);
if ($result && isset($result['status']) && $result['status'] === 'success') {
    // Transaction successful
    $transactionId = $result['data']['transaction_id'];
    // Process further...
} else {
    // Handle API error
    $error = $result['message'] ?? 'Unknown error';
}</pre>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
