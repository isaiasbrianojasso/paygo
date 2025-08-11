<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHollyDev;
use App\Http\Controllers\ControllerSMS;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebAuthnController;
use App\Models\User;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\WebAuthn;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllerAPI;
use App\Http\Controllers\IntegrationCredentialController;
// Esto registrará todas las rutas necesarias para WebAuthn

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/test-keys', function() {
        return [
            'public_key_loaded' => !empty(config('app.public_key')),
            'private_key_loaded' => !empty(config('app.private_key')),
            'public_key_length' => strlen(config('app.public_key') ?? ''),
            'private_key_length' => strlen(config('app.private_key') ?? ''),
            'public_key_preview' => substr(config('app.public_key') ?? '', 0, 50) . '...',
            'private_key_preview' => substr(config('app.private_key') ?? '', 0, 50) . '...'
        ];
    });


    Route::get('/credentials/{id}/decrypted', [IntegrationCredentialController::class, 'showDecrypted']);

    Route::post('/integration-credentials', [IntegrationCredentialController::class, 'store']);
    Route::put('/integration-credentials/{id}', [IntegrationCredentialController::class, 'update'])->name('integration-credentials.update');

    //VISTAS
    Route::get('/home', function () {
        return view('dashboard', [
            'SMS' => App\Models\SMS::all(),
        ]);
    });
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'SMS' => App\Models\SMS::all(),
        ]);
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::get('/api', function () {
        return view('api.api');
    })->name('api');


    Route::get('/api_config', [IntegrationCredentialController::class, 'showApiConfig'])->name('api_config');


    Route::get('/usuariobloqueado', function () {
        return view("Usuario Bloqueado");
    })->name('usuariobloqueado');

    Route::get('/payment_check_api', function () {
        return view("api.payment_check_api");
    })->name('payment_check_api');

    Route::get('/api_binance_id', function () {
        return view("api.api_binance_id");
    })->name('api_binance_id');

    Route::get('/payment_check', function () {
        return view("payment_check");
    })->name('payment_check');

    Route::get('/payment_binance', function () {
        return view("payment_binance");
    })->name('payment_binance');



    Route::get('/admin', function () {
        return view("/admin/admin");
    })->name('admin');


    //USUARIOS
    Route::get('/admin/user/', fn() => view('admin.user')->with('user',User::FindOrFail(base64_decode($_GET['token']))))->name('edit_usuario');
    Route::post('/users.create', [ControllerSMS::class, '  users.create']);

//qr
    Route::match(['get', 'post'], '/qr', [ControllerAPI::class, 'qr'])->name('qr');

    //METODOS
    Route::post('/enviandoSms', [ControllerSMS::class, 'enviandoSms']);
    Route::match(['get', 'post'], '/buscarSms', [ControllerHollyDev::class, 'buscarSms']);
    Route::match(['get', 'post'], '/buscarCall', [ControllerHollyDev::class, 'buscarCall']);
    Route::match(['get', 'post'], '/buscar_Apple_Remove', [ControllerHollyDev::class, 'buscar_Apple_Remove']);

    Route::get('/detailMessage', [ControllerHollyDev::class, 'detailMessage']);
    Route::match(['get', 'post'], '/regenerarCredenciales', [ControllerHollyDev::class, 'regenerarCredenciales']);
});

 Route::get('/pay/zeta', function () {
        return view('/pay/zeta', [
            'SMS' => App\Models\SMS::all(),
        ]);
    });
Route::get('/zeta', [ControllerHollyDev::class, 'processPayment'])->name('zeta');

//binance
Route::match(['get', 'post'], '/binance_check', [ControllerHollyDev::class, 'binance_check'])->name('binance_check');
Route::match(['get', 'post'], '/binance_id', [ControllerHollyDev::class, 'binance_id'])->name('binance_id');

Route::match(['get', 'post'], '/binance_check_id', [ControllerHollyDev::class, 'binance_check_id'])->name('binance_check_id');


Route::match(['get', 'post'], '/binance_pay', [ControllerHollyDev::class, 'binance_pay'])->name('binance_pay');
//Route::match(['get', 'post'], '/apiserviceshistorial', [ControllerHollyDev::class, 'apiserviceshistorial']);
Route::get('/form', [OCRController::class, 'form'])->name('ocr.form');
Route::post('/ocr-form', [OCRController::class, 'extractFromForm'])->name('ocr.extract');


// Rutas para Passkey
Route::post('/passkey/register', function (AttestationRequest $request) {
    return $request->toCreate();
})->name('passkey.register');

Route::post('/passkey/verify', function (AttestationRequest $request) {
   return $request->login(Auth::all());
})->name('passkey.verify');

