<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'PAGO_ID',
        'PAGO_FECHA',
        'PAGO_HORA',
        'SOLI_ID',
        'PAGO_MONTO',
        'PAGO_CAPITAL',
        'PAGO_INTERES',
        'PAGO_MORA',
        'PAGO_SEGURO',
        'PAGO_OTRO',
        'PAGO_IVA',
        'PAGO_ANTERIOR',
        'PAGO_SALDO',
        'EMPL_ID',
        'PAGO_REFERENCIA',
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'EMPL_ID', 'EMPL_ID');
    }
}
