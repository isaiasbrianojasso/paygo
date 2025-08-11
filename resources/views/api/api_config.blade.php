@include('layouts.header')
@php
$url = url('/');
$current = url()->current();
@endphp
<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="mb-3 d-flex align-items-center">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Configuración API</li>
            </ul>
            <h1 class="mb-0 page-header">Tus Datos</h1>
        </div>
    </div>

    <!-- Primer Formulario - Credenciales de API -->
    <div class="mb-4 border-0 card">
        <div class="panel">
            <div class="text-white bg-red-700 panel-heading">Credenciales de API</div>
        </div>
        <div class="card-body">
            <form id="apiCredentialsForm">
                @csrf
                <div class="row">
                    <div class="mx-auto col-md-8">
                        <div class="mb-3 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">TOKEN</span>
                            </div>
                            <input class="form-control" type="text" name="api_token" id="api_token"
                                   value="{{ Auth::user()->api_token }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" onclick="copiarAlPortapapeles('api_token')">
                                    <i class="fas fa-copy"></i> Copiar
                                </button>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onclick="regenerarCredenciales()">
                                <i class="fas fa-sync-alt"></i> Generar Nuevas Credenciales
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Segundo Formulario - Configuración de Integración -->
    <div class="border-0 card">
        <div class="panel">
            <div class="text-white bg-blue-700 panel-heading">Configuración de Integración</div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $isEdit = isset($credential) && $credential !== null;
            @endphp

            <form id="integrationForm" action="{{ $isEdit ? route('integration-credentials.update', $credential->id) : url('/integration-credentials') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <div class="row">
                    <div class="mx-auto col-md-8">
                        <!-- Chat ID -->
                        <div class="mb-3 form-group">
                            <label for="chat_id"><i class="fab fa-telegram"></i> Chat ID</label>
                            <input type="text" class="form-control @error('chat_id') is-invalid @enderror"
                                   id="chat_id" name="chat_id"
                                   value="{{ old('chat_id', $chat_id ?? '') }}"
                                   placeholder="Ingresa tu Chat ID" required>
                            @error('chat_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
<hr>
                        <!-- Webhook URL -->
                        <div class="mb-3 form-group">
                            <label for="url_webhook"><i class="fas fa-link"></i> Webhook URL</label>
                            <div class="input-group">
                                <input type="url" class="form-control @error('url_webhook') is-invalid @enderror"
                                       id="url_webhook" name="url_webhook"
                                       value="{{ old('url_webhook', $url_webhook ?? '') }}"
                                       placeholder="https://tudominio.com/webhook" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copiarAlPortapapeles('url_webhook')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @error('url_webhook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<hr>
<div class="mb-3 form-group">
                            <label for="token_telegram"><i class="fas fa-link"></i> Token Telegram</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('token_telegram') is-invalid @enderror"
                                       id="token_telegram" name="token_telegram"
                                       value="{{ old('token_telegram', $token_telegram ?? '') }}"
                                       placeholder="https://tudominio.com/webhook" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="copiarAlPortapapeles('token_telegram')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @error('token_telegram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- API Key -->
                        <div class="mb-3 form-group">
                            <label for="api_key"><i class="fas fa-key"></i> API Key Binance (Opcional)</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('api_key') is-invalid @enderror"
                                       id="api_key" name="api_key"
                                       value="{{ old('api_key') }}"
                                       placeholder="Ingresa tu API Key">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="api_key">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('api_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- API Secret -->
                        <div class="mb-4 form-group">
                            <label for="api_secret"><i class="fas fa-lock"></i> API Secret Binance (Opcional)</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('api_secret') is-invalid @enderror"
                                       id="api_secret" name="api_secret"
                                       value="{{ old('api_secret') }}"
                                       placeholder="Ingresa tu API Secret">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="api_secret">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('api_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Configuración
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END #content -->
<script>
    // Función para copiar texto al portapapeles
    function copiarAlPortapapeles(elementId) {
        const elemento = document.getElementById(elementId);
        if (!elemento) return;

        const texto = elemento.value;
        if (!texto) {
            mostrarNotificacion('No hay texto para copiar', 'warning');
            return;
        }

        // Seleccionar el texto
        elemento.select();
        elemento.setSelectionRange(0, 99999); // Para dispositivos móviles

        // Copiar al portapapeles
        document.execCommand('copy');

        // Mostrar notificación
        mostrarNotificacion('Texto copiado al portapapeles', 'success');
    }

    // Función para mostrar notificaciones con SweetAlert2
    function mostrarNotificacion(mensaje, tipo = 'info') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: tipo,
            title: mensaje
        });
    }

    // Función para alternar visibilidad de contraseña
    document.addEventListener('DOMContentLoaded', function() {
        // Delegación de eventos para los botones de mostrar/ocultar
        document.addEventListener('click', function(e) {
            if (e.target.closest('.toggle-password')) {
                const button = e.target.closest('.toggle-password');
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });

        // Función para alternar visibilidad de contraseña
    document.addEventListener('click', function(e) {
        if (e.target.closest('.toggle-password')) {
            const button = e.target.closest('.toggle-password');
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    });
    });

    // Alias para mantener compatibilidad con el código existente
    function copiarCodigo() {
        copiarAlPortapapeles('api_token');
    }
</script>

@include('layouts.footer')
