@include('layouts.header')

@php
$url = url('/');
$current = url()->current();
@endphp

<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="panel">
        <div class="panel-heading bg-orange-700 text-white strong">Call API Example</div>
    </div>

    <div class="card border-0">

        <div class="row mt-3 mb-3">
            <div class="col-10 mx-auto">
                <h2>Ejemplo Para Uso De Tu API Call</h2>
                <button class="btn btn-sm btn-primary position-absolute end-0 top-0 mt-1 me-1"
                onclick="copyToClipboard('codigo1')">Copiar</button>
                <div class="position-relative mb-3">

                    <pre><code id="codigo1">
$urlcallback = "tu dominio donde se dara el callback en modo post recibiras el sid como \$_POST['CallSid']; y el status como \$_POST['CallStatus'];";
$linkaudio = "poner tu link del archivo que se usara";
$to = "numero al que se le enviara el audio";
$url = "{{$url}}/Calls.json";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Content-Type: application/x-www-form-urlencoded",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "StatusCallback=$urlcallback&Url=$linkaudio&To=$to&From=$to&api_token={{ Auth::user()->api_token }}";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$res = json_decode($resp, true);

if (isset($res['sid'])) {
    // respuesta si la llamada fue exitosa
} else {
    // respuesta si la llamada falló
}
                    </code></pre>
                </div>
<hr>
                <h2>EJ call tiempo real</h2>

                <div class="position-relative mb-3">
                    <button class="btn btn-sm btn-primary position-absolute end-0 top-0 mt-1 me-1"
                        onclick="copyToClipboard('codigo2')">Copiar</button>
                    <pre><code id="codigo2">
$url = "{{$url}}/api/verReal";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Content-Type: application/x-www-form-urlencoded",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "CallSid=$Call_SID";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

echo $resp;
                    </code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END #content -->

<!-- BEGIN scroll-top-btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top">
    <i class="fa fa-angle-up"></i>
</a>
<!-- END scroll-top-btn -->

<!-- Modal de Números -->
<div class="modal fade" id="mostarNumeros">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Números Para este canal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <ul class="one" hidden id="mostrarNumbers"></ul>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Cerrar</a>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<!-- Script para copiar al portapapeles -->
<script>
    function copyToClipboard(id) {
        const codeElement = document.getElementById(id);
        const text = codeElement.innerText || codeElement.textContent;
        navigator.clipboard.writeText(text).then(() => {
            alert("¡Código copiado al portapapeles!");
        }).catch(err => {
            alert("Error al copiar: " + err);
        });
    }
</script>