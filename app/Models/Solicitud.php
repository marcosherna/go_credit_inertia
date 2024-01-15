<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Solicitud extends Model
{
    use HasUlids;
    protected $table = 'solicitud';
    protected $primaryKey = 'SOLI_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at 
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string';

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
        'SOLI_ESTADO', // Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
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


    public function Insert(){ 
        // insertar y devolver el id
        return DB::table($this->table)->insert($this->toArray());
    }

    public function montoMasInteres() {
        return doubleval($this->SOLI_MONTO) + ((doubleval($this->tasaInteres->TASA_VALOR) / 100) * $this->SOLI_MONTO);
    }

    public function cantidadCuotas() { 
        $cuotas = intval($this->plazo->PLAZ_VALOR) / intval($this->formaPago->FORM_VALOR); 
        return round($cuotas);
    }
    
    public function montoCuota() {
        return $this->montoMasInteres() / $this->cantidadCuotas();
    }

    public function cuotas(){
        $cuotas = $this->hasMany(Cuotas::class, 'SOLI_ID', 'SOLI_ID')->get(); 
        $cuotas->transform(function ($item) { 
            $item->ESTADO = $item->estado();
            $item->DIAS_VENCIDOS = $item->diasVencidos();
            return $item;
        });
        return $cuotas;
    }

    public function estaObservador (){
        $result = false;
        if (strpos($this->SOLI_OBSERVACION, '[OBSERVADO]-') !== false) {
            $result =  true;
        }
        return $result;
    }


    public function interesReal(){
        $interes = 0;

        switch($this->tasaInteres->getTasa()){
            case 'Unica':
                $interes = ($this->tasaInteres->TASA_VALOR / 100);
                break;
            case 'Mensual':
                $interes = ($this->tasaInteres->TASA_VALOR * ($this->plazo->PLAZ_VALOR / 30)) / 100; 
                break;
            case 'Anual':
                $interes = ((($this->tasaInteres->TASA_VALOR / 12) * ($this->plazo->PLAZ_VALOR / 30)) / 100); 
                break;
            default: 
                $interes = ($this->tasaInteres->TASA_VALOR / 100);
                break;
        }

        return $interes;
    }
}
