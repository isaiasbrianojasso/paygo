<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerHollyDev;
use App\Http\Controllers\ControllerSMS;
use App\Http\Controllers\ControllerAutoremove;
use App\Http\Controllers\XiaomiController;
use App\Http\Controllers\ControllerCall;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebAuthnController;
use App\Models\User;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\WebAuthn;
use Illuminate\Support\Facades\Auth;
// Esto registrará todas las rutas necesarias para WebAuthn

// O si prefieres solo la ruta de verificación:

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
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


    Route::get('/api_config', function () {
        return view("api.api_config");
    })->name('api_config');


    Route::get('/usuariobloqueado', function () {
        return view("Usuario Bloqueado");
    })->name('usuariobloqueado');

    Route::get('/payment_check_api', function () {
        return view("api.payment_check_api");
    })->name('payment_check_api');

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
Route::post('/zeta', [ControllerHollyDev::class, 'processPayment'])->name('zeta');

//binance
Route::match(['get', 'post'], '/binance_check', [ControllerHollyDev::class, 'binance_check'])->name('binance_check');
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

