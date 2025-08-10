<?php

// app/Http/Controllers/IntegrationCredentialController.php
namespace App\Http\Controllers;

use App\Services\CredentialService;
use Illuminate\Http\Request;

class IntegrationCredentialController extends Controller
{
    public function store(Request $request, CredentialService $svc)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'url_webhook' => 'required|string|max:2048|url',
            'chat_id'     => 'required|string|max:128',
            'api_key'     => 'nullable|string|min:16',
            'api_secret'  => 'nullable|string|min:16',
        ]);

        // Si viene api_key, prevenir duplicado (por usuario)
        if (!empty($data['api_key']) &&
            $svc->existsByApiKeyForUser($data['user_id'], $data['api_key'])) {
            return response()->json(['message' => 'API key ya registrada para este usuario'], 409);
        }

        $cred = $svc->store(
            $data['user_id'],
            $data['url_webhook'],
            $data['chat_id'],
            $data['api_key']   ?? null,
            $data['api_secret']?? null,
        );

        return response()->json([
            'id'         => $cred->id,
            'user_id'    => $cred->user_id,
            'last4'      => $cred->last4,
            'created_at' => $cred->created_at,
        ], 201);
    }

    public function showApiConfig()
    {
        $user = auth()->user();
        $credential = $user->integrationCredential;

        return view('api.api_config', [
            'credential' => $credential,
            'chat_id' => $credential->chat_id ?? '',
            'url_webhook' => $credential->url_webhook ?? ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CredentialService $svc, $id)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'url_webhook' => 'required|string|max:2048|url',
            'chat_id'     => 'required|string|max:128',
            'api_key'     => 'nullable|string|min:16',
            'api_secret'  => 'nullable|string|min:16',
        ]);

        // Find the credential by ID and user ID to ensure the user owns it
        $credential = \App\Models\IntegrationCredential::where('id', $id)
            ->where('user_id', $request->user_id)
            ->firstOrFail();

        // Only update api_key and api_secret if they are provided and not empty
        $apiKey = !empty($data['api_key']) ? $data['api_key'] : null;
        $apiSecret = !empty($data['api_secret']) ? $data['api_secret'] : null;

        // Update the credential
        $credential = $svc->update(
            $credential->id,
            $data['url_webhook'],
            $data['chat_id'],
            $apiKey,
            $apiSecret
        );

        return redirect()->route('api_config')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    public function showDecrypted(string $id)
    {
        $cred = \App\Models\IntegrationCredential::findOrFail($id);

        return response()->json([
            'id'          => $cred->id,
            'user_id'     => $cred->user_id,
            'url_webhook' => $cred->url_webhook,
            'chat_id'     => $cred->chat_id,
            'api_key'     => $cred->api_key_enc,
            'api_secret'  => $cred->api_secret_enc,
            'last4'       => $cred->last4,
            'created_at'  => $cred->created_at,
        ]);
    }
}
