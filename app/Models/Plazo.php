<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plazo extends Model{

    protected $table = 'plazo';
    protected $primaryKey = 'PLAZ_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'PLAZ_ID',
        'PLAZ_NOMBRE',
        'PLAZ_VALOR',
        'PLAZ_ESTADO',
    ];
}
