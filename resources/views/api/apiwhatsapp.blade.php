@include('layouts.header')
@php
$url = url('/');
$current = url()->current();
@endphp
<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Configuracion API</li>
            </ul>
            <h1 class="page-header mb-0">Tus Datos</h1>
        </div>

    </div>

    <div class="card border-0">

        <div class="panel">
            <div class="panel-heading bg-red-700 text-white">Tus Credenciales</div>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="input-group mt-2 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Tu api_token</span>
                    </div>
                    <input class="form-control" type="text" name="api_token" value="{{Auth::user()->api_token}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <button class="btn btn-danger" type="button" onclick="regenerarCredenciales()">Generar Nuevas
                    Credenciales</button>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="alert alert-danger">
                Para que se envie el mensaje en español debes enviar 1 en la variable idioma, recuerda siempre enviar el
                chat_id en el campo chat_id para que llegue la notificacion de visita y de remove de igual forma envia
                tu bot al administrador donde esten registrado tus usuarios donde llegara las notificaciones
            </div>
        </div>

        <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="allTab">
                <!-- BEGIN input-group -->
                <div class="row">

                </div>
                <!-- END input-group -->



            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-10 mx-auto">

                <h2>Ejemplo Para Uso De Tu API</h2>

                <h5 id="usoAPI">

                    $url =
                    "{{$url}}/api/envioApiWhatsapp/?envioApi&api_key={{Auth::user()->api_key}}&api_token={{Auth::user()->api_token}}&number=yournumber&chat_id=645xxxxxx&idioma=1";
                    <br>
                    $curl = curl_init($url);<br>
                    curl_setopt($curl, CURLOPT_URL, $url);<br>
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);<br>
                    <br>
                    //for debug only!<br>
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);<br>
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);<br>
                    <br>
                    $resp = curl_exec($curl);<br>
                    curl_close($curl);<br>
                    $enviado = json_decode($resp, true);<br>
                    if($enviado["ok"] == true){<br>
                    //Mensaje Enviado<br>
                    $mensaje=$enviado['mensaje'];<br>
                    <br>
                    }else{<br>
                    //error mensaje no enviado<br>
                    }<br>
                </h5>

            </div>
        </div>



    </div>
</div>
<!-- END #content -->

@include('layouts.footer')