<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaEmpleado extends Model
{
    protected $table = 'ruta_empleado';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'RUTA_ID',
        'EMPL_ID',
    ];

    public function ruta() {
        return $this->belongsTo(Ruta::class, 'RUTA_ID', 'RUTA_ID');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'EMPL_ID', 'EMPL_ID');
    }
}
