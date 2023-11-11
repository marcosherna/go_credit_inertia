<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    protected $primaryKey = 'BITA_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'BITA_ID',
        'BITA_ACCION',
        'BITA_REGISTROS',
        'BITA_TABLA',
        'USUA_LOGIN',
        'BITA_ESTATUS',
        'BITA_IP',
        'BITA_FECHA',
        'BITA_HORA',
    ];
}
