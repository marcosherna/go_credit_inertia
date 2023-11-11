<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiadores extends Model
{
    protected $table = 'fiadores';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'CLIE_ID',
        'FIAD_FECHA',
        'EMPL_ID',
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'CLIE_ID', 'CLIE_ID');
    }

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'EMPL_ID', 'EMPL_ID');
    }
}
