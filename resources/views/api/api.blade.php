@include('layouts.header')
@php
$url = url('/');
$current = url()->current();
@endphp
<!-- BEGIN #content -->
<div id="content" class="app-content">
     <div class="panel">
            <div class="panel-heading bg-orange-700 text-white strong">SMS API Example</div>
        </div>
            <input class="form-control" type="hidden" name="api_token" id="api_token"
                        value="{{Auth::user()->api_token}}">
    <div class="border-0 card">
                <div class="mt-4 shadow-sm card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Ejemplo Para Uso De Tu API</h4>
                <button class="btn btn-sm btn-outline-primary" onclick="copiarCodigoAPI()">
                    Copiar código
                </button>
            </div>
        <div class="p-3 tab-content">
            <div class="tab-pane fade show active" id="allTab">
                <!-- BEGIN input-group -->
                <div class="row">
                    <div class="col-12">
                        <select class="form-control" name="senderApi"
                            onchange="cambiarUrlApi({{App\Models\Sender::all()}})">
                            <option value="">-- Selecciona --</option> {{-- opción por defecto --}}
                            @foreach (App\Models\Sender::all() as $sender)
                            <option value="{{ $sender->sender_id }}">
                                {{ $sender->sender_name }} — costo: [ ${{ $sender->costo }} C ]
                            </option>
                            @endforeach

                        </select>


                    </div>
                </div>
                <!-- END input-group -->



            </div>
        </div>


            <div class="card-body">
                <div class="row">
                    <div class="mx-auto col-10">
                        <pre class="p-3 rounded bg-light">
          <code id="codigoAPI2" class="usoAPI">
          $url = "{{$url}}/apiV2?token={{Auth::user()->api_token}}&sender=1&numero=yournumber&msj=your+message";

          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          // for debug only!
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          $resp = curl_exec($curl);
          curl_close($curl);

          $enviado = json_decode($resp, true);
          if ($enviado["ok"] == "ok") {
              // Mensaje Enviado
          } else {
              // error mensaje no enviado
          }
          </code>
                  </pre>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function copiarCodigoAPI() {
              const codigo = document.getElementById("codigoAPI2").innerText;
              navigator.clipboard.writeText(codigo).then(() => {
                alert("Código copiado al portapapeles ✅");
              }).catch(err => {
                alert("Error al copiar el código ❌");
                console.error(err);
              });
            }
        </script>
<!--
        <div class="mt-3 mb-3 row">
            <div class="mx-auto col-10">

                <h2>Coneccion Con Todos Nuestros Senders</h2>

                <h5 id="usoPrimeraVez">

                    $sender = $_POST['sender'];<br>
                    $number = $_POST['number'];<br>
                    $msj = url_encode($_POST['msj']);<br><br>

                    $url =
                    "{{$url}}/apiV2/&token={{Auth::user()->api_token}}&sender=$sender&number=$number&msj=$msj";
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
                    if(isset($enviado["ok"])){<br>
                    if($enviado["ok"] == "ok"){<br>
                    //Mensaje Enviado<br>}<br>
                    }else{<br>
                    //error mensaje no enviado<br>
                    }<br>
                </h5>

            </div>
        </div>
    </div>-->
</div>
<!-- END #content -->

@include('layouts.footer')
