<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model {
    protected $table = 'municipio';
    protected $primaryKey = 'MUNI_ID';
    public $timestamps = false;

    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'MUNI_ID',
        'MUNI_NOMBRE',
        'DEPA_ID',
        'PAIS_ID',
        'MUNI_ESTADO',
    ];

    // Relación con el departamento
    public function departamento() {
        return $this->belongsTo(Departamento::class, 'DEPA_ID', 'DEPA_ID');
    }

    // Relación con el país
    public function pais() {
        return $this->belongsTo(Pais::class, 'PAIS_ID', 'PAIS_ID');
    }
}
