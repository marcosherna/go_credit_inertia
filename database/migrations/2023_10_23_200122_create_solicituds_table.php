<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->string('SOLI_ID', 37)->primary()->comment('Id Solicitud');
            $table->date('SOLI_FECHA')->comment('Fecha de Creación');
            $table->string('EMPL_ID', 37)->comment('Ejecutivo que la Crea');
            $table->string('CLIE_ID', 10)->comment('ID Cliente. Ref tabla cliente');
            $table->double('SOLI_MONTO', 8, 2)->comment('Monto Solicitado');
            $table->string('TIPO_ID', 37)->default('')->comment('Tipo de Credito Ref. Tabla Tipo_credito');
            $table->string('GARA_ID', 37)->comment('Garantia del Credito. Ref. Tabla Garantias');
            $table->string('PLAZ_ID', 37)->comment('Plazo del Credito. Ref Tabla Plazos');
            $table->string('FORM_ID', 37)->comment('Periodo de Pago. Ref. tabla Formas de Pago');
            $table->string('TIPT_ID', 37)->comment('Tipo Tasa Interes. Ref. Tabla tipo_interes');
            $table->string('TASA_ID', 37)->comment('Tasa de Interes. Ref. Tabla tasa_interes');
            $table->tinyInteger('SOLI_TIPOTASA')->default(0)->comment('0 -> Mensual; 1-> Anual 2-> Fija');
            $table->tinyInteger('SOLI_OMITIRDOM')->default(0)->comment('Omitir Domingos: 0->NO 1->SI');
            $table->tinyInteger('SOLI_DISPERSAR')->default(0)->comment('Dispersar Domingo: 0->NO 1->SI');
            $table->string('SOLI_CATEGORIA', 5)->nullable()->comment('Categoria Credito: A1,A2,B1,B2,C,D,E');
            $table->date('SOLI_FECHAAPROB')->nullable()->comment('Fecha Aprobacion Credito');
            $table->date('SOLI_FECHAVENCIMIENTO')->nullable()->comment('Fecha de Vencimiento');
            $table->string('SOLI_OBSERVACION', 200)->nullable()->comment('Observaciones a Solicitud');
            $table->string('SOLI_CONDICIONES', 200)->nullable()->comment('Condiciones Adicionales');
            $table->string('SOLI_OTROS', 200)->nullable()->comment('Otras Observaciones');
            $table->tinyInteger('SOLI_ESTADO')->comment('Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada');

            $table->unique('SOLI_ID');
            $table->index('SOLI_MONTO');
            $table->index('SOLI_ESTADO');
            $table->index('SOLI_CATEGORIA');
            $table->index('EMPL_ID');
            $table->index('CLIE_ID');
            $table->index('TIPO_ID');
            $table->index('GARA_ID');
            $table->index('PLAZ_ID');
            $table->index('FORM_ID');
            $table->index('TIPT_ID');
            $table->index('TASA_ID');

            $table->foreign('EMPL_ID')->references('EMPL_ID')->on('empleado');
            $table->foreign('CLIE_ID')->references('CLIE_ID')->on('cliente');
            $table->foreign('TIPO_ID')->references('TIPO_ID')->on('tipo_credito');
            $table->foreign('GARA_ID')->references('GARA_ID')->on('garantia');
            $table->foreign('PLAZ_ID')->references('PLAZ_ID')->on('plazo');
            $table->foreign('FORM_ID')->references('FORM_ID')->on('forma_pago');
            $table->foreign('TIPT_ID')->references('TIPO_ID')->on('tipo_interes');
            $table->foreign('TASA_ID')->references('TASA_ID')->on('tasa_interes');
        });
    }

    public function down() {
        Schema::dropIfExists('solicitud');
    }
};
