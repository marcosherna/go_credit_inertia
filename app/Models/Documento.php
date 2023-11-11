<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model {

    protected $table = 'documento';
    protected $primaryKey = 'DOCU_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'DOCU_ID', 'DOCU_NOMBRE', 'DOCU_DESCRIPCION', 'DOCU_PLANTILLA', 'EMPR_ID', 'USUA_LOGIN', 'FECHA_CAMBIO', 'HORA_CAMBIO',
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'EMPR_ID', 'EMPR_ID');
    }

    public function usuario() {
        return $this->belongsTo(Empleado::class, 'USUA_LOGIN', 'EMPL_ID');
    }
}
