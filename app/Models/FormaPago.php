<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model {

    protected $table = 'forma_pago';
    protected $primaryKey = 'FORM_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'FORM_ID',
        'FORM_NOMBRE',
        'FORM_VALOR',
        'FORM_ESTADO', // Estado Credito 0-Inactivo 1-Activo
    ];
}
