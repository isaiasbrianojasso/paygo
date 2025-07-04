<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twilio extends Model
{
    protected $table = 'twilios'; // asegúrate del nombre
    public $timestamps = true;
    public $primaryKey = 'twilio_id';
}
