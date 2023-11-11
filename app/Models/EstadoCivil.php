<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table = 'estado_civil';
    protected $primaryKey = 'ESTA_ID';
    public $timestamps = true;
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'ESTA_ID',
        'ESTA_NOMBRE',
        'ESTA_ESTADO',
    ];

    // Relación con Estado Civil
    public function empleados() {
        return $this->hasMany(Empleado::class, 'ESTA_ID', 'ESTA_ID');
    }
}
