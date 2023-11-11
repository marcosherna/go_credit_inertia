<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCredito extends Model {
    protected $table = 'tipo_credito';
    protected $primaryKey = 'TIPO_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'TIPO_ID',
        'TIPO_NOMBRE',
        'TIPO_ABREV',
        'TIPO_ESTADO',
    ];
}
