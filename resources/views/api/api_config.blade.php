@include('layouts.header')

@php
    $url = url('/');
    $current = url()->current();
    $isEdit = isset($credential) && $credential !== null;
@endphp

<div id="content" class="app-content container py-4">

    <!-- Breadcrumb y título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item active">Configuración API</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-0">Tus Datos</h1>
        </div>
    </div>

    <!-- Credenciales de API -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-danger text-white fw-semibold">
            <i class="fas fa-shield-alt me-2"></i> Credenciales de API
        </div>
        <div class="card-body">
            <form id="apiCredentialsForm">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Token</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="text" class="form-control" id="api_token" name="api_token"
                                value="{{ Auth::user()->api_token }}" readonly>
                            <button class="btn btn-outline-primary" type="button"
                                onclick="copiarAlPortapapeles('api_token')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onclick="regenerarCredenciales()">
                                <i class="fas fa-sync-alt me-1"></i> Generar Nuevas Credenciales
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Configuración de Integración -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-plug me-2"></i> Configuración de Integración
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle me-1"></i> {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="integrationForm"
                  action="{{ $isEdit ? route('integration-credentials.update', $credential->id) : url('/integration-credentials') }}"
                  method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <!-- Chat ID -->
                        <div class="mb-3">
                            <label for="chat_id" class="form-label fw-semibold"><i class="fab fa-telegram me-1"></i> Chat ID</label>
                            <input type="text" class="form-control @error('chat_id') is-invalid @enderror"
                                id="chat_id" name="chat_id"
                                value="{{ old('chat_id', $chat_id ?? '') }}"
                                placeholder="Ingresa tu Chat ID" required>
                            @error('chat_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Webhook URL -->
                        <div class="mb-3">
                            <label for="url_webhook" class="form-label fw-semibold"><i class="fas fa-link me-1"></i> Webhook URL</label>
                            <div class="input-group">
                                <input type="url" class="form-control @error('url_webhook') is-invalid @enderror"
                                    id="url_webhook" name="url_webhook"
                                    value="{{ old('url_webhook', $url_webhook ?? '') }}"
                                    placeholder="https://tudominio.com/webhook" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="copiarAlPortapapeles('url_webhook')">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @error('url_webhook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Token Telegram -->
                        <div class="mb-3">
                            <label for="token_telegram" class="form-label fw-semibold"><i class="fas fa-robot me-1"></i> Token Telegram</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('token_telegram') is-invalid @enderror"
                                    id="token_telegram" name="token_telegram"
                                    value="{{ old('token_telegram', $token_telegram ?? '') }}"
                                    placeholder="Token de tu bot de Telegram" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="copiarAlPortapapeles('token_telegram')">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @error('token_telegram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- API Key -->
                        <div class="mb-3">
                            <label for="api_key" class="form-label fw-semibold"><i class="fas fa-key me-1"></i> API Key Binance (Opcional)</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('api_key') is-invalid @enderror"
                                    id="api_key" name="api_key" value="{{ old('api_key') }}"
                                    placeholder="Ingresa tu API Key">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="api_key">
                                    <i class="far fa-eye"></i>
                                </button>
                                @error('api_key')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- API Secret -->
                        <div class="mb-4">
                            <label for="api_secret" class="form-label fw-semibold"><i class="fas fa-lock me-1"></i> API Secret Binance (Opcional)</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('api_secret') is-invalid @enderror"
                                    id="api_secret" name="api_secret" value="{{ old('api_secret') }}"
                                    placeholder="Ingresa tu API Secret">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="api_secret">
                                    <i class="far fa-eye"></i>
                                </button>
                                @error('api_secret')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-1"></i> Guardar Configuración
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function copiarAlPortapapeles(elementId) {
        const elemento = document.getElementById(elementId);
        if (!elemento || !elemento.value) return Swal.fire('Atención', 'No hay texto para copiar', 'warning');
        navigator.clipboard.writeText(elemento.value).then(() => {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Copiado al portapapeles', showConfirmButton: false, timer: 2000 });
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.toggle-password')) {
            const btn = e.target.closest('.toggle-password');
            const input = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    });
</script>

@include('layouts.footer')
