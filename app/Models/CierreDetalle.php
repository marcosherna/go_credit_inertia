<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreDetalle extends Model {
    protected $table = 'cierre_detalle';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'CIER_ID',
        'CIED_CORR',
        'CIED_REF',
        'CIED_CONCEPTO',
        'CIED_CANTIDAD',
        'CIED_UNIDAD',
        'CIED_MONTO',
    ];

    public function cierre() {
        return $this->belongsTo(Cierre::class, 'CIER_ID', 'CIER_ID');
    }
}
