<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->string('DOCU_ID', 37)->comment('ID Documento');
            $table->string('DOCU_NOMBRE', 50)->comment('Nombre Documento');
            $table->string('DOCU_DESCRIPCION', 200)->comment('Detalle Doumento');
            $table->binary('DOCU_PLANTILLA')->nullable()->comment('Plantilla Documento');
            $table->string('EMPR_ID', 37)->comment('ID Empresa -> Ref. Tabla Empresa');
            $table->string('USUA_LOGIN', 37)->nullable()->comment('Usuario que realiza el documento');
            $table->date('FECHA_CAMBIO')->nullable()->comment('Fecha de Cambio Documento');
            $table->time('HORA_CAMBIO')->nullable()->comment('Hora Cambio Documento');

            $table->primary('DOCU_ID');
            $table->unique('DOCU_ID');
            $table->index('DOCU_NOMBRE');
            $table->index('EMPR_ID');
            $table->index('USUA_LOGIN');

            $table->foreign('EMPR_ID')->references('EMPR_ID')->on('empresa');
            $table->foreign('USUA_LOGIN')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documento');
    }
};
