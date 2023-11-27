<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model {

    protected $table = 'cuotas';
    protected $primaryKey = 'CUOT_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'CUOT_FECHAPAGO',
        'CUOT_NUMERO',
        'CUOT_MONTO',
        'CUOT_CAP',
        'CUOT_INT',
        'CUOT_SEG',
        'CUOT_OTRO',
        'CUOT_ABONO',
        'CUOT_CAPITAL',
        'CUOT_INTERES',
        'CUOT_MORA',
        'CUOT_SEGUROS',
        'CUOT_PENALIDAD',
        'CUOT_BONIFICACION',
        'CUOT_FECHAREC',
        'CUOT_ESTADO',
        'CUOT_MORA_ESTADO',
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    } 
}
