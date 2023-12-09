<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInteres extends Model {

    use HasFactory;
    protected $table = 'tipo_interes';
    protected $primaryKey = 'TIPO_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at
    
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string';

    protected $fillable = [
        'TIPO_ID',
        'TIPO_NOMBRE',
        'TIPO_DESCRIPCION',
        'TIPO_ESTADO', // Estado 0-Inactivo 1-Activo
    ];
}
