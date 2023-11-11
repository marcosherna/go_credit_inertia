<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model {
    protected $table = 'tickets';
    protected $primaryKey = 'TICK_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'TICK_ID',
        'TICK_FECHACREACION',
        'TICK_HORACREACION',
        'TICK_FECHAAPROB',
        'TICK_HORAAPROB',
        'TTICK_ID',
        'TICK_USUARIO',
        'TICK_USUAAUTORIZA',
        'TICK_REFERENCIA',
        'TICK_COMENTARIOS',
        'TICK_ESTADO',
    ];

    public function tipoTicket() {
        return $this->belongsTo(TipoTicket::class, 'TTICK_ID', 'TTICK_ID');
    }

    public function usuario() {
        return $this->belongsTo(Empleado::class, 'TICK_USUARIO', 'EMPL_ID');
    }

    public function usuarioAutoriza() {
        return $this->belongsTo(Empleado::class, 'TICK_USUAAUTORIZA', 'EMPL_ID');
    }
}
