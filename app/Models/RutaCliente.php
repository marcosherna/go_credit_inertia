<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaCliente extends Model
{
    protected $table = 'ruta_cliente';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'RUTA_ID',
        'CLIE_ID',
    ];

    public function ruta() {
        return $this->belongsTo(Ruta::class, 'RUTA_ID', 'RUTA_ID');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'CLIE_ID', 'CLIE_ID');
    }

}
