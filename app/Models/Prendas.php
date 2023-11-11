<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prendas extends Model
{
    protected $table = 'prendas';
    protected $primaryKey = 'PREN_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'PREN_NOMBRE',
        'PREN_MARCA',
        'PREN_MODELO',
        'PREN_PRECIO',
        'PREN_PRECIOGARANTA',
        'PREN_DETALLE',
        'PREN_ANOFABRICACION',
        'PREN_IMAGEN',
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    }
}
