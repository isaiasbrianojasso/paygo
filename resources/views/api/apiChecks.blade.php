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

            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="input-group mt-2 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tu api_key</span>
                        </div>
                        <input class="form-control" type="text" name="api_key" value="{{Auth::user()->api_key}}">
                    </div>
                </div>
            </div>
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
                <button class="btn btn-info" type="button" onclick="ComprarMembresia()">Comprar Membresía</button>
            </div>
        </div>

        <div class="row">
            <div class="alert alert-info">
                Tienes hasta el </br>
                Has usado tu api 0 De 0 veces
            </div>
        </div>


        <div class="row mt-3 mb-3">

            <div class="col-10 mx-auto">

                <h2>Ejemplo Para Uso De Tu API Check</h2>

                <h5 id="usoAPI">

                    $url = "{{$url}}/api/envioCheck";</br>
                    </br>
                    $curl = curl_init($url);</br>
                    curl_setopt($curl, CURLOPT_URL, $url);</br>
                    curl_setopt($curl, CURLOPT_POST, true);</br>
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);</br>
                    </br>
                    $headers = array(</br>
                    "Content-Type: application/x-www-form-urlencoded",</br>
                    );</br>
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);</br>
                    </br>
                    $data = "numero=52xxxxxxxxxx&api_key={{Auth::user()->api_key}}&api_token={{Auth::user()->api_token}}";</br>
                    </br>
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);</br>
                    </br>
                    //for debug only!</br>
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);</br>
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);</br>
                    </br>
                    $resp = curl_exec($curl);</br>
                    curl_close($curl);</br>



                    $respuesta = json_decode($resp, true);</br></br>

                    if(!isset($respuesta['ok']){</br>
                    $country_code = $respuesta['country_code'];</br>
                    $country_name = $respuesta['country_name'];</br>
                    $location = $respuesta['location'];</br>
                    $carrier = $respuesta['carrier'];</br>
                    </br></br>
                    }</br>
                    </br></br>



                </h5>

            </div>
        </div>



    </div>
</div>
<!-- END #content -->


<!-- BEGIN scroll-top-btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i
        class="fa fa-angle-up"></i></a>
<!-- END scroll-top-btn -->


</div>
<!-- END #app -->




<!-- #Nuevo Proveedor -->
<div class="modal fade" id="mostarComprar">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Numeros Para este canal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="mb-3">

                        <div class="form-group">
                            <label for="my-select"><i class="fas fa-apple-whole fa-lg"></i> Selecciona Tu Mejor
                                Opcion</label>
                            <select class="form-control form-control-lg" name="costo">


                                <option value="10">5,000 API Requests 30 dias --- $10</option>
                                <option value="50">50,000 API Requests 30 dias --- $50</option>
                                <option value="100">250,000 API Requests 30 dias --- $100 </option>
                            </select>

                            <span class="text-danger" id="errorSender" hidden></span>
                        </div>
                    </div>




                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" onclick="solicitarMembresia()">Solicitar</a>
                        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>


                    </div>
                </div>
            </div>
        </div>



        @include('layouts.footer')