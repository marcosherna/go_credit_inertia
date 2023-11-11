<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $primaryKey = 'SOLI_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'SOLI_FECHA',
        'EMPL_ID',
        'CLIE_ID',
        'SOLI_MONTO',
        'TIPO_ID',
        'GARA_ID',
        'PLAZ_ID',
        'FORM_ID',
        'TIPT_ID',
        'TASA_ID',
        'SOLI_TIPOTASA',
        'SOLI_OMITIRDOM',
        'SOLI_DISPERSAR',
        'SOLI_CATEGORIA',
        'SOLI_FECHAAPROB',
        'SOLI_FECHAVENCIMIENTO',
        'SOLI_OBSERVACION',
        'SOLI_CONDICIONES',
        'SOLI_OTROS',
        'SOLI_ESTADO',
    ];

    public function empleado() {
        return $this->belongsTo(Empleado::class, 'EMPL_ID', 'EMPL_ID');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'CLIE_ID', 'CLIE_ID');
    }

    public function tipoCredito() {
        return $this->belongsTo(TipoCredito::class, 'TIPO_ID', 'TIPO_ID');
    }

    public function garantia() {
        return $this->belongsTo(Garantia::class, 'GARA_ID', 'GARA_ID');
    }

    public function plazo() {
        return $this->belongsTo(Plazo::class, 'PLAZ_ID', 'PLAZ_ID');
    }

    public function formaPago() {
        return $this->belongsTo(FormaPago::class, 'FORM_ID', 'FORM_ID');
    }

    public function tipoInteres() {
        return $this->belongsTo(TipoInteres::class, 'TIPT_ID', 'TIPO_ID');
    }

    public function tasaInteres() {
        return $this->belongsTo(TasaInteres::class, 'TASA_ID', 'TASA_ID');
    }
}
