<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTicket extends Model
{
    protected $table = 'tipo_ticket';
    protected $primaryKey = 'TTICK_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'TTICK_ID',
        'TTICK_NOMBRE',
        'TTICK_DETALLE',
    ];
}
