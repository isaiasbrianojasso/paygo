@include('layouts.header')

@php
$url = url('/');
$apiToken = Auth::user()->api_token;
@endphp

<div id="content" class="app-content">
    <div class="panel">
        <div class="panel-heading bg-orange-700 text-white strong">Google API Example</div>
    </div>

    <div class="card border-0">
        <label for="select_google" class="panel">Choice Option</label>
        <select class="form-control" name="select_google" onchange="select_google(this.value)">
            <option disabled selected>Selecciona una opción</option>
            <option value="remove_report">Clean Domain Report safebrowsing</option>
            <option value="check_domain">Check Domain Status</option>
            <option value="google_maps">Google Maps API</option>
        </select>

        <div class="row mt-3 mb-3">
            <div class="col-10 mx-auto">
                <h5 class="usoAPI text-orange-600 font-mono">
                    Selecciona una opción para ver el código.
                </h5>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col-10 mx-auto">
                <div class="apiResponse alert alert-secondary" style="display: none;">
                    <strong>Resultado:</strong>
                    <pre class="mb-0 text-success" id="resultado_api">...</pre>
                </div>
            </div>
        </div>

        <script>
            function select_google(option) {
                const baseUrl = "{{ $url }}";
                const apiToken = "{{ $apiToken }}";
                const domainExample = "https://google.com";

                let endpoint = "";
                let resultadoSimulado = "";

                switch(option) {
                    case "remove_report":
                        endpoint = "remove_report";
                        resultadoSimulado = JSON.stringify({ status: "success", domain: "google.com", removed: true }, null, 4);
                        break;
                    case "check_domain":
                        endpoint = "api_google_check";
                        resultadoSimulado = JSON.stringify({ status: "clean", domain: "google.com", category: "safe" }, null, 4);
                        break;
                    case "google_maps":
                        endpoint = "google_maps";
                        resultadoSimulado = JSON.stringify({ location: "Mexico City", lat: 19.4326, lng: -99.1332 }, null, 4);
                        break;
                }

                const fullUrl = `${baseUrl}/${endpoint}?api_key=${apiToken}&domain=${domainExample}`;
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
            }
        </script>
    </div>
</div>

@include('layouts.footer')