<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Transaccion extends Model
{
    protected $table = 'detalle_transaccions';

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

    // Relación con la tabla transaccions
    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class, 'id_transaccion');
    }

    // Relación con usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
