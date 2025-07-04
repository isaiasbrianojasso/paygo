@include('layouts.header')

@php
    $url = url('/');
    $apiToken = Auth::user()->api_token;
@endphp

<div id="content" class="app-content">
    <div class="panel">
        <div class="panel-heading bg-orange-700 text-white strong">Payment API Example paygo.lat</div>
    </div>

    <div class="card border-0">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('assets/img/paygo.png') }}" class="ml-auto mr-auto "width="20%" alt="Paygo Logo" class="img-fluid">
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-10 mx-auto">
                <h5 class="usoAPI text-orange-600 font-mono" >
                    Selecciona una opción para ver el código.
                </h5>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col-10 mx-auto">
                <div class="apiResponse alert alert-secondary" style="display: none;">
                    <strong>Resultado:</strong>
                    <pre class="mb-0 text-success">{"response":"Dep\u00f3sito recibido:\nID: 4472694833681092866\nMonto: 30 USDT (TRX)\nTxID: Off-chain transfer 255246137765\nDirecci\u00f3n: TN2bgYx4PcwMQeGqBDWu894CgHcwkfFJMa\nConfirmaciones: 1\/1"}</pre>
                </div>
            </div>
        </div>

        <script>
                const baseUrl = "{{ $url }}";
                const apiToken = "{{ $apiToken }}";
                let endpoint = "";
                let resultadoSimulado = "";


                const fullUrl = `${baseUrl}/binance_check?api_key=${apiToken}&txId=abcdefghijklmnopqrs`;
                const codeExample = `
$url = "${fullUrl}";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
if ($resp) {
    return $resp;
} else {
    // error
}
                `;

                document.querySelector('.usoAPI').innerHTML = `<pre>${codeExample}</pre>`;
                document.querySelector('.apiResponse').style.display = 'block';
                document.getElementById('resultado_api').textContent = resultadoSimulado;

        </script>
    </div>
</div>

@include('layouts.footer')
