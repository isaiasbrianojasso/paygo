<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaccion extends Model
{
    protected $table = 'transaccions';

    protected $fillable = [
    'transaccion_id',
        'monto_binance',
        'monto_usuario',
        'respuesta_binance',
        'status',
        'cuenta_binance_origen',
        'cuenta_binance_destino',
        'acreditado',
        'captura_imagen',
        'id_transaccion',
        'user_id',
        'tipo',
        'referencia',
        'descripcion',
        'identifier',
        'servicio',
        'banco',
        'token_auth'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalleTransacciones()
    {
        return $this->hasMany(detalle_transaccion::class, 'id_transaccion');
    }
}
