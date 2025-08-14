<?php

namespace App\Http\Controllers;

use App\Services\CredentialService;
use Illuminate\Http\Request;
use App\Models\IntegrationCredential;

class IntegrationCredentialController extends Controller
{
    public function store(Request $request, CredentialService $svc)
    {
        $data = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'url_webhook'    => 'required|string|max:2048|url',
            'chat_id'        => 'required|string|max:128',
            'token_telegram' => 'nullable|string|max:2048',
            'qr' => 'nullable',
            'api_key'        => 'nullable|string|min:16',
            'api_secret'     => 'nullable|string|min:16',
        ]);

        $image = $request->file('qr');
            $imageName = 'temp_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('temp', $imageName, 'public');


            // Obtener la ruta absoluta de la imagen
            $absolutePath = storage_path('app/public/' . $imagePath);



        // Prevenir duplicado de API key por usuario
        if (!empty($data['api_key']) &&
            $svc->existsByApiKeyForUser($data['user_id'], $data['api_key'])) {
                /*
            return response()->json(['message' => 'API key ya registrada para este usuario'], 409);*/

        return redirect()->route('api_config')
            ->with('success', 'Configuración actualizada exitosamente');
        }

        $cred = $svc->store(
            $data['user_id'],
            $data['url_webhook'],
            $data['token_telegram'] ?? null,
            $data['chat_id'],
            $absolutePath, // Guardar la ruta de la imagen en lugar del contenido
            $data['api_key'] ?? null,
            $data['api_secret'] ?? null
        );
/*
        return response()->json([
            'id'         => $cred->id,
            'user_id'    => $cred->user_id,
            'last4'      => $cred->last4,
            'created_at' => $cred->created_at,
        ], 201);*/

        return redirect()->route('api_config')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    public function showApiConfig()
    {
        $user = auth()->user();
        $credential = $user->integrationCredential;

        return view('api.api_config', [
            'credential'     => $credential,
            'chat_id'        => $credential->chat_id ?? '',
            'url_webhook'    => $credential->url_webhook ?? '',
            'token_telegram' => $credential->token_telegram ?? '',
            'qr' => $credential->qr ?? '',
            'api_key'        => $credential->api_key ?? '',
            'api_secret'     => $credential->api_secret ?? '',
        ]);
    }

    public function update(Request $request, CredentialService $svc, $id)
    {
        $data = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'url_webhook'    => 'nullable|string|max:2048|url',
            'token_telegram' => 'nullable|string|max:2048',
            'chat_id'        => 'nullable|string|max:128',
            'api_key'        => 'nullable|string|min:16',
            'qr'        => 'nullable',
            'api_secret'     => 'nullable|string|min:16',
        ]);

        $image = $request->file('qr');
        if ($image) {
            // Guardar la imagen en storage/app/public/qr_codes
            $imageName = 'qr_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('qr_codes', $imageName, 'public');
            
            // Usar solo el path relativo para la base de datos
            $qrPath = 'storage/' . $imagePath;
        } else {
            // Si no se subió una nueva imagen, mantener la existente
            $qrPath = $credential->qr ?? null;
        }

        $credential = IntegrationCredential::where('id', $id)
            ->where('user_id', $data['user_id'])
            ->firstOrFail();

        $credential = $svc->update(
            $credential->id,
            $data['url_webhook'],
            $data['token_telegram'] ?? null,
            $data['chat_id'],
            $qrPath, // Usar el path relativo para la base de datos
            $data['api_key'] ?: null,
            $data['api_secret'] ?: null
        );

        return redirect()->route('api_config')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    public function showDecrypted(string $id)
    {
        $cred = IntegrationCredential::findOrFail($id);
  //$cred = IntegrationCredential::where('user_id', $id)->firstOrFail();
        return response()->json([
            'id'            => $cred->id,
            'user_id'       => $cred->user_id,
            'url_webhook'   => $cred->url_webhook,
            'token_telegram'=> $cred->token_telegram,
            'chat_id'       => $cred->chat_id,
            'qr'       => $cred->qr,

            'api_key'       => $cred->getDecryptedApiKey(),
            'api_secret'    => $cred->getDecryptedApiSecret(),
            'last4'         => $cred->last4,
            'created_at'    => $cred->created_at,
        ]);

    }
}
