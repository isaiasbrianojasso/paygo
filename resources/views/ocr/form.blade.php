@include('layouts.header')
<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="card border-0">
        <div class="panel">
            <div class="panel-heading bg-blue-700 text-white strong">Check Payment Transfer</div>
        </div>

        <body class="p-4">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/paygo.png') }}" class="ml-auto mr-auto " width="20%" alt="Paygo Logo"
                    class="img-fluid">
            </div>
            <h2>Subir Comprobante para OCR</h2>

            <form action="{{ route('ocr.extract') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="comprobante" class="form-label">Selecciona una imagen (.jpg, .png)</label>
                    <input type="file" name="comprobante" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Procesar</button>
            </form>

            @if (isset($data))
            <h4>Datos extraídos:</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Fecha:</strong> {{ $data['fecha'] }}</li>
                <li class="list-group-item"><strong>Clave de rastreo:</strong> {{ $data['clave_rastreo'] }}</li>
                <li class="list-group-item"><strong>Emisor:</strong> {{ $data['emisor'] }}</li>
                <li class="list-group-item"><strong>Receptor:</strong> {{ $data['receptor'] }}</li>
                <li class="list-group-item"><strong>Cuenta:</strong> {{ $data['cuenta'] }}</li>
                <li class="list-group-item"><strong>Monto (pesos):</strong> {{ $data['monto'] }}</li>
            </ul>
            @endif

            @include('layouts.footer')