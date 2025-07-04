<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SMS extends Model
{
    protected $fillable = [
        'id_user',
        'msj',
        'number',
        'sender',
        'api_id',
        'status',
        'sender_id',
        'costo',
        'sender_name',
    ];
    public $incrementing = false; // Desactiva incremento automático
    protected $keyType = 'string'; // El UUID es un string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
