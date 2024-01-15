<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model {

    protected $table = 'empleado';
    protected $primaryKey = 'EMPL_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'EMPL_ID', 'EMPL_NOMBRE', 'EMPL_NOMBRE2', 'EMPL_APELLIDO', 'EMPL_APELLIDO2', 'EMPL_APELLIDO3',
        'EMPL_FOTO', 'EMPL_SEXO', 'ESTA_ID', 'PAIS_NAC', 'DEPA_NAC', 'EMPL_FECHANAC', 'EMPL_DOCIDEN',
        'EMPL_DOCFISCAL', 'EMPL_PASAPORTE', 'EMPL_ISSS', 'EMPL_NUP', 'EMPL_ANTECEDENTES', 'PAIS_ID',
        'DEPA_ID', 'MUNI_ID', 'EMPL_DIRECCION', 'EMPL_TEL', 'EMPL_TEL2', 'EMPL_MAIL', 'EMPL_MAIL2',
        'EMPL_ESTADO', 'SUCU_ID', 'EMPR_ID', 'USUA_LOGIN', 'FECHA_CAMBIO',
    ];

    public function fullName() {
        return $this->EMPL_NOMBRE . ' ' . $this->EMPL_NOMBRE2 . ' ' . $this->EMPL_APELLIDO . ' ' . $this->EMPL_APELLIDO2;
    }

    public function estadoCivil() {
        return $this->belongsTo(EstadoCivil::class, 'ESTA_ID', 'ESTA_ID');
    }

    public function paisNacimiento() {
        return $this->belongsTo(Pais::class, 'PAIS_NAC', 'PAIS_ID');
    }

    public function departamentoNacimiento() {
        return $this->belongsTo(Departamento::class, 'DEPA_NAC', 'DEPA_ID');
    }

    public function pais() {
        return $this->belongsTo(Pais::class, 'PAIS_ID', 'PAIS_ID');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'DEPA_ID', 'DEPA_ID');
    }

    public function municipio() {
        return $this->belongsTo(Municipio::class, 'MUNI_ID', 'MUNI_ID');
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'EMPR_ID', 'EMPR_ID');
    }

    public function nombreCompleto(){
        return $this->EMPL_NOMBRE . ' ' . $this->EMPL_NOMBRE2 . ' ' . $this->EMPL_APELLIDO . ' ' . $this->EMPL_APELLIDO2;
    }
}
