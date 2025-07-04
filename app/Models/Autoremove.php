<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autoremove extends Model
{
    protected $fillable = [
        'id_user',
        'apple_id',
        'password',
        'status',
        'response',
        'borrado',

    ];
}
