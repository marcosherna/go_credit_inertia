<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulo';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'MODU_ID',
        'MODU_NOMBRE',
        'MODU_DETALLE',
        'MODU_TIPO',
        'MODU_ESTADO',
    ];
}
