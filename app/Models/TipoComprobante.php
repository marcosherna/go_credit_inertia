<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = 'tipo_comprobante';
    protected $primaryKey = 'TIPC_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'TIPC_ID',
        'TIPC_NOMBRE',
        'TIPC_DETALLE',
        'TIPC_FISCAL',
        'TIPC_ESTADO',
    ];
}
