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
                        <span class="input-group-text">TOKEN</span>
                    </div>
                    <input class="form-control" type="text" name="api_token" id="api_token"
                        value="{{Auth::user()->api_token}}">
                    <button class="btn btn-sm btn-outline-primary" onclick="copiarCodigo()">
                        Copy Token
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <button class="btn btn-danger" type="button" onclick="regenerarCredenciales()">Generar Nuevas
                    Credenciales</button>
            </div>
        </div>
    </div>
</div>
<!-- END #content -->
<script>
    function copiarCodigo() {
      const codigo = document.getElementById("api_token").value;
      navigator.clipboard.writeText(codigo).then(() => {
        alert("Código copiado al portapapeles ✅");
      }).catch(err => {
        alert("Error al copiar el código ❌");
        console.error(err);
      });
    }
</script>

@include('layouts.footer')