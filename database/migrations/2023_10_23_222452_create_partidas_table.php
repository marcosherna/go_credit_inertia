<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('partida', function (Blueprint $table) {
            $table->string('PART_ID', 37)->comment('ID Partida');
            $table->date('PART_FECHA')->comment('Fecha de Transaccion');
            $table->integer('PART_TIPO')->default(3)->comment('Tipo Partida. 1-Ingreso 2-Egreso 3-Diario 4-Provision 5-CxP 6-CxC 7-Cierre 8-Apertura');
            $table->string('PART_CONCEPTO', 255)->comment('Concepto de Partida');
            $table->date('PART_REGISTRO')->comment('Fecha de Registro');
            $table->string('USUA_REGISTRO', 37)->nullable()->comment('Usuario que registra Ref tabla usuario');
            $table->date('PART_CAMBIO')->nullable()->comment('Fecha de Modificacion');
            $table->string('USUA_MODIFICA', 10)->nullable()->comment('Usuario que modifica');
            $table->string('EMPR_ID', 37)->comment('Empresa ID. Ref. empresa');
            $table->string('SUCU_ID', 37)->comment('Sucursal ID. Ref. sucursal');
            $table->integer('PART_ESTADO')->default(1)->comment('Estado partida 1-Generada 2-Eliminada 3-Procesada');

            $table->primary('PART_ID');
            $table->unique('PART_ID');
            $table->index('PART_FECHA');
            $table->index('PART_TIPO');
            $table->index('PART_ESTADO');
            $table->index('USUA_REGISTRO');
            $table->index('EMPR_ID');
            $table->index('SUCU_ID');

            $table->foreign('USUA_REGISTRO')->references('EMPL_ID')->on('empleado');
            $table->foreign('EMPR_ID')->references('EMPR_ID')->on('empresa');
            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partida');
    }
};
