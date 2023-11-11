<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'ruta';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'RUTA_ID',
        'RUTA_NOMBRE',
        'RUTA_REFERENCIA',
        'RUTA_DETALLE',
        'SUCU_ID',
        'RUTA_ESTADO',
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }
}
