<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variables extends Model
{
    protected $table = 'variables';
    protected $primaryKey = 'VARI_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'VARI_ID',
        'VARI_NOMBRE',
        'VARI_VALOR',
        'VARI_DETALLE',
        'TIPV_ID',
    ];

    public function tipoVariable() {
        return $this->belongsTo(TipoVariable::class, 'TIPV_ID', 'TIPV_ID');
    }
}
