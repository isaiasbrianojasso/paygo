<?php
// app/Services/CredentialService.php
namespace App\Services;

use App\Models\IntegrationCredential;
use Illuminate\Support\Facades\Hash;

class CredentialService
{
    public function store(
        int|string $userId,
        string $urlWebhook,
        string $token_telegram,
        string $chatId,
        ?string $apiKey,
        ?string $apiSecret
    ): IntegrationCredential {
        $payload = [
            'user_id'     => $userId,
            'token_telegram' => $token_telegram,
            'url_webhook' => $urlWebhook,
            'chat_id'     => $chatId,
            'key_version' => 1,
        ];

        if ($apiKey !== null && $apiKey !== '') {
            $payload['api_key_hash']   = Hash::make($apiKey);
            $payload['api_key_sha256'] = hash('sha256', $apiKey);
            $payload['api_key_enc']    = $apiKey;    // cast encrypted
            $payload['last4']          = mb_substr($apiKey, -4);
        }

        if ($apiSecret !== null && $apiSecret !== '') {
            $payload['api_secret_enc'] = $apiSecret; // cast encrypted
        }

        return IntegrationCredential::create($payload);
    }

    public function existsByApiKeyForUser(int|string $userId, string $apiKey): bool
    {
        $sha256hex = hash('sha256', $apiKey);
        return IntegrationCredential::where('user_id', $userId)
            ->where('api_key_sha256', $sha256hex)
            ->exists();
    }

    public function verify(string $id, string $providedApiKey): bool
    {
        $cred = IntegrationCredential::findOrFail($id);
        if (!$cred->api_key_hash) return false;
        return Hash::check($providedApiKey, $cred->api_key_hash);
    }

    /** Devuelve [apiKey|null, apiSecret|null] ya descifrados por cast */
    public function getPlainForUse(string $id): array
    {
        $cred = IntegrationCredential::findOrFail($id);
        return [$cred->api_key_enc, $cred->api_secret_enc];
    }

    /**
     * Update an existing integration credential
     *
     * @param int|string $id
     * @param string $urlWebhook
     * @param string $chatId
     * @param string $qr
     * @param string|null $token_telegram If null or empty, the existing value will be preserved
     * @param string|null $apiKey If null or empty, the existing value will be preserved
     * @param string|null $apiSecret If null or empty, the existing value will be preserved
     * @return IntegrationCredential
     */
    public function update(
        int|string $id,
        string $urlWebhook,
        string $token_telegram,
        string $chatId,
        string $qr,
        ?string $apiKey,
        ?string $apiSecret
    ): IntegrationCredential {
        $credential = IntegrationCredential::findOrFail($id);

        // Always update these fields
        $credential->url_webhook = $urlWebhook;
        $credential->chat_id = $chatId;
         $credential->qr = $qr;
        $credential->token_telegram = $token_telegram;
        // Only update API key if a new one is provided
        if ($apiKey !== null && $apiKey !== '') {
            $credential->api_key_hash = Hash::make($apiKey);
            $credential->api_key_sha256 = hash('sha256', $apiKey);
            $credential->api_key_enc = $apiKey; // cast encrypted
            $credential->last4 = mb_substr($apiKey, -4);
        }

        // Only update API secret if a new one is provided
        if ($apiSecret !== null && $apiSecret !== '') {
            $credential->api_secret_enc = $apiSecret; // cast encrypted
        }

        $credential->save();

        return $credential->fresh();
    }
}
