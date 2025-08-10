@include('layouts.header')

<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="card border-0">
        <div class="panel">
            <div class="panel-heading bg-blue-700 text-white strong">Usuarios</div>
        </div>
        <div class="card-body">
            <form action="/user/update" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control"
                        autocomplete="name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control"
                        autocomplete="email">
                </div>
                    <div class="mb-3">
                    <label for="telegram_token" class="form-label">Telegram Bot token webhook</label>
                    <input type="text" name="telegram_token" id="telegram_token" value="{{ $user->telegram_token }}" class="form-control"
                        autocomplete="telegram_token">
                </div>
                <div class="mb-3">
                    <label for="chatid" class="form-label">Telegram CHAT ID</label>
                    <input type="text" name="chatid" id="chatid" value="{{ $user->chatid }}" class="form-control"
                        autocomplete="chatid">
                </div>
                <div class="mb-3">
                    <label for="binance" class="form-label">Binance API (Only read mode)</label>
                    <input type="text" name="binance" id="binance" value="{{ $user->chatid }}" class="form-control"
                        autocomplete="binance">
                </div>


                <div class="mb-3">
                    <label for="habilitado" class="form-label">Habilitado</label>
                    <select name="habilitado" class="form-select">
                        <option value="0" {{ $user->habilitado === 0 ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ $user->habilitado === 1 ? 'selected' : '' }}>SI</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select name="role" id="role" class="form-select">
                        <option value="admin" {{ $user->rol === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="member" {{ $user->rol === 'member' ? 'selected' : '' }}>Member</option>
                        <option value="customer" {{ $user->rol === 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control"
                        autocomplete="new-password">
                    <small class="text-muted">Déjalo en blanco si no deseas cambiarla</small>
                </div>

                <div class="d-flex justify-content-end">

                    <a href="/admin" class="btn btn-info  col-md-4">
                        <i class="bi bi-check-circle"></i> Regresar
                    </a>

                    <button type="submit" class="btn btn-success col-md-4">
                        <i class="bi bi-check-circle"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@include('layouts.footer')
