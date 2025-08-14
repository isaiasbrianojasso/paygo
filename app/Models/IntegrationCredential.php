<?php
// app/Models/IntegrationCredential.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class IntegrationCredential extends Model
{
    use HasUuids;

    protected $table = 'integration_credentials';

    protected $fillable = [
        'user_id',
        'url_webhook', 'chat_id', 'token_telegram',
        'api_key_hash', 'api_key_sha256',
        'api_key_enc', 'api_secret_enc',
        'key_version', 'last4', 'qr',
    ];

    protected $casts = [
        'api_key_enc'    => 'encrypted',
        'api_secret_enc' => 'encrypted',
    ];

    protected $hidden = [
        'api_key_hash', 'api_key_sha256',
        'api_key_enc', 'api_secret_enc',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
