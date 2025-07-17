<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaccion extends Model
{
    protected $table = 'transaccions';

    protected $fillable = [
        'user_id',
        'status',
        'monto',
        'cuenta_origen',
        'cuenta_destino',
        'acreditado',
        'token_auth',
        'captura',
        'moneda',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalleTransacciones()
    {
        return $this->hasMany(detalle_transaccion::class, 'id_transaccion');
    }
}
