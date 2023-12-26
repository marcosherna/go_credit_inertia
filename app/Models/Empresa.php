<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {

    protected $table = 'empresa';
    protected $primaryKey = 'EMPR_ID';
    public $timestamps = false;
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria


    protected $fillable = [
        'EMPR_ID',
        'EMPR_NOMBRE',
        'EMPR_NOMCORTO',
        'EMPR_SLOGAN',
        'EMPR_LOGO',
        'EMPR_DIRECCION',
        'EMPR_TEL',
        'EMPR_FAX',
        'EMPR_WEB',
        'TIPO_ID',
        'EMPR_GERENTE',
        'EMPR_GERENTEMAIL',
        'EMPR_GERENTETEL',
        'EMPR_TECNICO',
        'EMPR_TECNICOMAIL',
        'EMPR_TECNICOTEL',
        'PAIS_ID',
        'DEPA_ID',
        'MUNI_ID',
        'EMPR_PADRE',
        'EMPR_ESTADO',
    ];

    public function tipoEmpresa() {
        return $this->belongsTo(TipoEmpresa::class, 'TIPO_ID', 'TIPO_ID');
    }
}
