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
use Illuminate\Http\Request;
use \App\Models\IntegrationCredential;
use Illuminate\Support\Facades\Storage;
// Esto registrará todas las rutas necesarias para WebAuthn


Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/test-keys', function () {
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
    Route::get('/admin/user/', fn() => view('admin.user')->with('user', User::FindOrFail(base64_decode($_GET['token']))))->name('edit_usuario');
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

Route::match(['get', 'post'], '/validatePay', function (Request $request) {
    // Validate required parameters;
    if (!$request->has('api_key')) {
        return response()->json([
            'status' => 'error',
            'message' => 'API key parameter is required'
        ], 400);
    }

    // Find user by API token
    $user = User::where('api_token', $request->api_key)->first();


    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid API key'
        ], 401);
    }
    return view('validatePay.pay', [
        'api_key' => $request->api_key
    ]);

});

Route::match(['get', 'post'], '/validatePay/actionPay.php', [ControllerHollyDev::class, 'processPayment'])->name('zeta');

//binance
Route::match(['get', 'post'], '/binance_check', [ControllerHollyDev::class, 'binance_check'])->name('binance_check');
Route::match(['get', 'post'], '/binance_id', [ControllerHollyDev::class, 'binance_id'])->name('binance_id');

Route::match(['get', 'post'], '/binance_check_id', [ControllerHollyDev::class, 'binance_check_id'])->name('binance_check_id');



Route::match(['get', 'post'], '/api_binance_website/{api}', function (Request $request, $api) {

    // Usar el parámetro de la URL como api_key si no viene en POST/GET
    $apiKey = $request->api_key ?? $api;

    // Validar que exista la api_key
    if (!$apiKey) {
        return response()->json([
            'status' => 'error',
            'message' => 'API key parameter is required'
        ], 400);
    }

    // Buscar usuario por API key
    $user = User::where('api_token', $apiKey)->first();
    $integration = IntegrationCredential::where('user_id', $user->id)->first();
    $qr = Storage::url($integration->qr);
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid API key'
        ], 401);
    }

    // Retornar la vista con el api_key
    return view('validatePay.website', [
        'api_key' => $apiKey,
        'qr' => $qr ?? 'https://via.placeholder.com/220?text=QR+no+disponible'

    ]);
});



Route::get('/descargar-index', function () {
    // 1) Usuario logueado
    $user = Auth::user();
    if (!$user) {
        abort(403, 'Usuario no autenticado');
    }

    // 2) api_key y webhook
    $apiKey  = $user->api_token;
    $webhook = IntegrationCredential::where('user_id', $user->id)->first();

    // 3) Validaciones
    if (!$webhook || !$webhook->url_webhook) {
        abort(404, 'URL de webhook no encontrada');
    }

    // 4) Obtener SOLO el origen (scheme + host [+ port]), sin parámetros ni path
    $p      = parse_url($webhook->url_webhook);
    $scheme = $p['scheme'] ?? 'https';
    $host   = $p['host']   ?? '';
    $port   = isset($p['port']) ? ':' . $p['port'] : '';
    if ($host === '') {
        abort(422, 'URL de webhook inválida');
    }
    $url = rtrim("$scheme://$host$port", '/'); // <-- AHORA $url EXISTE

    // 5) Contenido del archivo
    $contenido = '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head><body style="margin:0">'
        . '<iframe src="' . $url . '/validatePay/?api_key=' . e($apiKey) . '" width="100%" height="100%" frameborder="0" style="border:0;width:100vw;height:100vh"></iframe>'
        . '</body></html>';

    // 6) Guardar y descargar
    $path = storage_path('app/index.php');
    file_put_contents($path, $contenido);

    return response()->download($path, 'index.php')->deleteFileAfterSend(true);
});


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


