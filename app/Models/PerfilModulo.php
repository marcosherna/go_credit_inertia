<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilModulo extends Model
{
    protected $table = 'perfil_modulo';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'PERM_ID',
        'PERF_ID',
        'MODU_ID',
        'PERM_ACCESAR',
        'PERM_VER',
        'PERM_NUEVO',
        'PERM_EDITAR',
        'PERM_BORRAR',
        'PERM_PROCESAR',
        'PERM_LIMITARUSUARIO',
        'PERM_REPORTES',
        'PERM_EXPLORAR',
    ];

    public function perfil() {
        return $this->belongsTo(Perfil::class, 'PERF_ID', 'PERF_ID');
    }

    public function modulo() {
        return $this->belongsTo(Modulo::class, 'MODU_ID', 'MODU_ID');
    }
}
