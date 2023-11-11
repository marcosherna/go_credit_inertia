<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEmpresa extends Model {

    protected $table = 'tipo_empresa';
    protected $primaryKey = 'TIPO_ID';
    public $timestamps = false;

    protected $fillable = [
        'TIPO_ID',
        'TIPO_NOMBRE',
        'TIPO_ESTADO',
    ];
}
