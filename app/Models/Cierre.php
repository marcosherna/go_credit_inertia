<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    protected $table = 'cierre';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'CIER_ID',
        'CIER_FECHA',
        'CIER_HORA',
        'SUCU_ID',
        'CIER_FECHACIERRE',
        'CIER_TOTALTRANS',
        'CIER_SISTEMA',
        'CIER_CONTABLE',
        'CIER_CAJA',
        'CIER_ENTRADAS',
        'CIER_SALIDAS',
        'CIER_AJUSTE',
        'CIER_CONCEPTO',
        'CIER_USERCAJERO',
        'CIER_USERAUTORIZA',
        'CIER_ESTADO',
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }

    public function cierreDetalle() {
        return $this->hasMany(CierreDetalle::class, 'CIER_ID', 'CIER_ID');
    }

    public function empleadoCajero() {
        return $this->belongsTo(Empleado::class, 'CIER_USERCAJERO', 'EMPL_ID');
    }

    public function empleadoAutoriza()
    {
        return $this->belongsTo(Empleado::class, 'CIER_USERAUTORIZA', 'EMPL_ID');
    }
}
