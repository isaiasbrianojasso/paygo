<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $table = 'numbers'; // asegúrate del nombre
    public $timestamps = true;
    public $primaryKey = 'number_id';
}
