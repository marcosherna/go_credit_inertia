<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model {
    use HasFactory;
    protected $table = 'cliente';
    protected $primaryKey = 'CLIE_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'CLIE_NOMBRE', 
        'CLIE_NOMBRE2', 
        'CLIE_NOMBRE3', 
        'CLIE_APELLIDO', 
        'CLIE_APELLIDO2',
        'CLIE_APELLIDO3', 
        'CLIE_SEXO', 
        'ESTA_ID', 
        'PAIS_NAC', 
        'DEPA_NAC', 
        'CLIE_FECHANAC',
        'CLIE_DOCIDEN', 
        'CLIE_DOCIDENVEN', 
        'CLIE_DOCFISCAL', 
        'CLIE_PASAPORTE', 
        'CLIE_OTRODOC',
        'CLIE_OTRODOC2', 
        'CLIE_ANTECEDENTES', 
        'PAIS_ID', 
        'DEPA_ID', 
        'MUNI_ID', 
        'CLIE_DIRECCION',
        'CLIE_TEL', 
        'CLIE_TEL2', 
        'CLIE_MAIL', 
        'CLIE_MAIL2', 
        'CLIE_TIPOCASA', 
        'CLIE_PROFESION',
        'CLIE_TIPOEMPLEO', 
        'CLIE_TRABAJO', 
        'CLIE_TRABAJODIR', 
        'CLIE_TRABAJOTEL', 
        'CLIE_INGRESOPROM',
        'CLIE_INGRESOS', 
        'CLIE_INGRESOADIC', 
        'CLIE_INGRESOORIGEN', 
        'CLIE_REF1NOMBRE',
        'CLIE_REF1PARENTESCO', 
        'CLIE_REF1DIRECCION', 
        'CLIE_REF1TELEFONO', 
        'CLIE_REF2NOMBRE',
        'CLIE_REF2PARENTESCO', 
        'CLIE_REF2DIRECCION', 
        'CLIE_REF2TELEFONO', 
        'CLIE_REF3NOMBRE',
        'CLIE_REF3PARENTESCO', 
        'CLIE_REF3DIRECCION', 
        'CLIE_REF3TELEFONO', 
        'CLIE_COMENTARIOS',
        'CLIE_OBSERVACIONES', 
        'CLIE_TIPOCLIENTE', 
        'CLIE_CATEGORIA', 
        'CLIE_SCORE', 
        'CLIE_ESTADO',
        'SUCU_ID', 
        'EMPR_ID', 
        'USUA_LOGIN', 
        'FECHA_CAMBIO'
    ];

    public function estadoCivil() { return $this->belongsTo(EstadoCivil::class, 'ESTA_ID', 'ESTA_ID'); }
    public function paisNacimiento() { return $this->belongsTo(Pais::class, 'PAIS_NAC', 'PAIS_ID'); }
    public function departamentoNacimiento() { return $this->belongsTo(Departamento::class, 'DEPA_NAC', 'DEPA_ID'); }
    public function pais() { return $this->belongsTo(Pais::class, 'PAIS_ID', 'PAIS_ID'); }
    public function departamento() { return $this->belongsTo(Departamento::class, 'DEPA_ID', 'DEPA_ID'); }
    public function municipio() { return $this->belongsTo(Municipio::class, 'MUNI_ID', 'MUNI_ID'); }
    public function sucursal() { return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID'); }
    public function empresa() { return $this->belongsTo(Empresa::class, 'EMPR_ID', 'EMPR_ID'); }

    public function insert(){
        DB::table($this->table)->insert($this->toArray());
    }

    public function solicitudeCreditos() { 
        $solicitudes = Solicitud::select('SOLI_ID','SOLI_CATEGORIA', 'SOLI_FECHAAPROB', 'SOLI_FECHAVENCIMIENTO','SOLI_ESTADO', 'SOLI_MONTO')
            ->where('CLIE_ID', $this->CLIE_ID)
            ->where('SOLI_ESTADO', 4)
            ->orderBy('SOLI_FECHAAPROB', 'desc')
            ->take(3)   
            ->get();

        return $solicitudes;
    }
}
