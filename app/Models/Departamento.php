<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model {
    protected $table = 'departamento';
    protected $primaryKey = 'DEPA_ID';
    public $timestamps = false; // Si no necesitas timestamps (created_at, updated_at)
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'DEPA_ID',
        'DEPA_NOMBRE',
        'DEPA_REGION',
        'PAIS_ID',
        'DEPA_ESTADO',
    ];

    // Relación con el país
    public function pais() {
        return $this->belongsTo(Pais::class, 'PAIS_ID', 'PAIS_ID');
    }
}
