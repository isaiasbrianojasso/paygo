@include('layouts.header')
<!-- BEGIN #content -->
@php
$url = url('/');
$current = url()->current();
@endphp
<div id="content" class="app-content">
    <div class="panel">
        <div class="panel-heading bg-orange-700 text-white strong">Autoremove API Example</div>
    </div>
    <div class="border-0 card">
        <!--
        <div class="panel">
            <div class="text-white bg-red-700 panel-heading">Tus Credenciales</div>
        </div>
        <div class="row">
            <div class="mx-auto col-6">
                <div class="mt-2 mb-3 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">IP Registradas</span>
                    </div>
                    <input class="form-control" type="text" name="ip" value="">
                </div>
            </div>
        </div>-->


        <div class="row">
            <div class="alert alert-info">
                <div class="row">
                    <div class="m-2 mx-auto col-4-md ">
                        <button class="btn btn-info" type="button" onclick="ComprarMembresia()">Comprar
                            Membresía</button>
                    </div>
                </div>
                Tienes {{ $activos = App\Models\IP::where('user_id',
                Auth::user()->id)->where('service','apple_remove')->count()}} IPs Disponibles para Autoremove Apple<br>
            </div>
        </div>
        <div class="mt-4 mb-4 row">
            <div class="mx-auto col-10">
                <div class="shadow-sm card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Ejemplo para Uso de Tu API Autoremove</h4>
                        <button class="btn btn-sm btn-outline-primary" onclick="copiarCodigo()">
                            Copiar código
                        </button>
                    </div>
                    <div class="card-body">
                        <pre class="p-3 rounded bg-light"><code id="codigoAPI">
          // !!! IMPORTANT:
          // La contraseña debe enviarse codificada en base64

          // Ejemplo INCORRECTO:
          $password = $_POST['password'];

          // Ejemplo CORRECTO:
          $password = base64_encode($_POST['password']);

          --------------------------------------------------

          $url = "{{$url}}/snnccheck";

          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          $headers = array(
              "Content-Type: application/x-www-form-urlencoded",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

          $data = "appleid=correoapple@gmail.com&password=$password&response=text";

          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

          // Solo para pruebas (desactiva la verificación SSL)
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          $resp = curl_exec($curl);
          curl_close($curl);
                  </code></pre>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function copiarCodigo() {
              const codigo = document.getElementById("codigoAPI").innerText;
              navigator.clipboard.writeText(codigo).then(() => {
                alert("Código copiado al portapapeles ✅");
              }).catch(err => {
                alert("Error al copiar el código ❌");
                console.error(err);
              });
            }
        </script>





    </div>
</div>
<!-- END #content -->


<!-- BEGIN scroll-top-btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i
        class="fa fa-angle-up"></i></a>
<!-- END scroll-top-btn -->


</div>
<!-- END #app -->





@include('layouts.footer')