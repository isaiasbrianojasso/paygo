<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Http\Controllers\Controller;
use Laragear\WebAuthn\WebAuthn; // Import the WebAuthn class

class WebAuthnController extends Controller
{
    protected $webauthn;

    public function __construct(WebAuthn $webauthn)
    {
        $this->middleware('auth')->except(['loginOptions', 'loginVerify']);
        $this->webauthn = $webauthn;
    }

    /**
     * Mostrar la vista para registrar una nueva passkey.
     */
    public function showRegistrationForm()
    {
        return view('passkeys.register');
    }

    /**
     * Generar opciones de creación (challenge) para el navegador.
     */
    public function registerOptions(Request $request)
    {
        return $this->webauthn->prepareRegistration(Auth::user());
    }

    /**
     * Verificar y guardar una nueva passkey.
     */
    public function registerVerify(Request $request)
    {
        $this->webauthn->validateAttestation(Auth::user(), $request);

        return response()->json(['success' => true, 'message' => 'Passkey registrada correctamente.']);
    }

    /**
     * Generar opciones de login para WebAuthn.
     */
    public function loginOptions(Request $request)
    {
        return $this->webauthn->prepareAssertion($request->input('email'));
    }

    /**
     * Verificar passkey e iniciar sesión.
     */
    public function loginVerify(Request $request)
    {
        $user = $this->webauthn->validateAssertion($request);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    /**
     * Eliminar una passkey del usuario autenticado.
     */
    public function deleteCredential($id)
    {
        Auth::user()->webAuthnCredentials()->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Passkey eliminada.');
    }
}
