<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    protected $table = 'a_p_i_s'; // asegúrate del nombre
    public $timestamps = true;
    public $primaryKey = 'api_id'; // si tienes alguna clave alternativa
    protected $fillable = [

    ];
    protected $casts = [
        'fecha' => 'datetime',
    ];
    public function usuario() {
        return $this->belongsTo(User::class);
    }

    public function asesor() {
        return $this->belongsTo(User::class, 'asesor_id'); // o el modelo correcto
    }
}
