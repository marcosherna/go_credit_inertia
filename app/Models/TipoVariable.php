<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVariable extends Model
{
    protected $table = 'tipo_variable';
    protected $primaryKey = 'TIPV_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'TIPV_ID',
        'TIPV_NOMBRE',
        'TIPV_DETALLE',
        'TIPV_ESTADO',
    ];
}
