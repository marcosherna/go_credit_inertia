<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasaInteres extends Model {

    protected $table = 'tasa_interes';
    protected $primaryKey = 'TASA_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'TASA_ID',
        'TASA_VALOR',
        'TASA_TIPO',
        'TASA_ESTADO', // Estado Tasa. 0-Inactivo 1-Activo
    ];

    public function getTasa(){
        $tipos = [
            0 => 'Unica',
            1 => 'Mensual',
            2 => 'Anual'
        ];
        return $tipos[$this->TASA_TIPO];
    }
}
