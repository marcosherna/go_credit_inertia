<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->string('CUOT_ID', 37)->comment('ID Cuota');
            $table->string('SOLI_ID', 37)->comment('ID Solicitud');
            $table->date('CUOT_FECHAPAGO')->comment('Fecha de Pago Cuota');
            $table->string('CUOT_NUMERO', 10)->comment('Numero de Cuota');
            $table->double('CUOT_MONTO', 10, 6)->comment('Valor Cuota');
            $table->double('CUOT_CAP', 10, 6)->nullable()->comment('Capital Proyectado');
            $table->double('CUOT_INT', 10, 6)->nullable()->comment('Interes Proyectado');
            $table->double('CUOT_SEG', 10, 6)->nullable()->comment('Seguro Proyectado');
            $table->double('CUOT_OTRO', 10, 6)->nullable()->comment('Otro Cargo Proyectado');
            $table->double('CUOT_ABONO', 10, 6)->default(0)->comment('Cantidad abonada en cuota');
            $table->double('CUOT_CAPITAL', 10, 6)->default(0)->comment('Cantidad abonada a Capital');
            $table->double('CUOT_INTERES', 10, 6)->default(0)->comment('Monto abonado a interes');
            $table->double('CUOT_MORA', 10, 6)->default(0)->comment('Monto abonado a Mora');
            $table->double('CUOT_SEGUROS', 10, 6)->nullable()->comment('Cuota de Seguro');
            $table->double('CUOT_PENALIDAD', 10, 6)->default(0)->comment('Monto destinado a Penalizacion');
            $table->double('CUOT_BONIFICACION', 10, 6)->default(0)->comment('Monto por Bonificacion pago Puntual');
            $table->date('CUOT_FECHAREC')->nullable()->comment('Fecha de Pago');
            $table->integer('CUOT_ESTADO')->comment('Estado de Pago. 0-Pendiente 1-Aplicado 2-Anulado/Pendiente 3-Devuelto/Pendiente 4-Aplicado por pago anticipado');
            $table->integer('CUOT_MORA_ESTADO')->nullable()->comment('Estado de Mora 0-Pendiente 1-Pagado 2-Saltado');

            $table->primary('CUOT_ID');
            $table->unique('CUOT_ID');
            $table->index('CUOT_ESTADO');
            $table->index('SOLI_ID');

            $table->foreign('SOLI_ID')->references('SOLI_ID')->on('solicitud');
        });
    }

    public function down() {
        Schema::dropIfExists('cuotas');
    }
};
