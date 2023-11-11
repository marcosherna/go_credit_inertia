<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('cierre', function (Blueprint $table) {
            $table->string('CIER_ID', 37)->comment('ID Cierre');
            $table->date('CIER_FECHA')->nullable()->comment('Fecha de Cierre');
            $table->time('CIER_HORA')->nullable()->comment('Hora de Cierre');
            $table->string('SUCU_ID', 37)->nullable()->comment('Id de Sucursal Ref. Tabla sucursal');
            $table->date('CIER_FECHACIERRE')->nullable()->comment('Dia de Cierre');
            $table->float('CIER_TOTALTRANS', 10, 0)->default(0)->comment('Total de Transacciones en Sistema');
            $table->float('CIER_SISTEMA', 10, 2)->default(0.00)->comment('Total Cierre Sistema. Ref. tabla Transacciones');
            $table->float('CIER_CONTABLE', 10, 2)->default(0.00)->comment('Total Cierre sistema. Ref. tabla cuenta_movimiento');
            $table->float('CIER_CAJA', 10, 2)->default(0.00)->comment('Total Cierre manual en Caja. dinero físico');
            $table->float('CIER_ENTRADAS', 10, 2)->default(0.00)->comment('Total Dinero entrante. Ref. transacciones');
            $table->float('CIER_SALIDAS', 10, 2)->default(0.00)->comment('Total Monto salida. Ref. tabla transacciones');
            $table->float('CIER_AJUSTE', 10, 2)->default(0.00)->comment('Ajuste de Sobrenta/Faltante. Calculado');
            $table->string('CIER_CONCEPTO', 255)->nullable()->comment('Observaciones de la operación');
            $table->string('CIER_USERCAJERO', 37)->nullable()->comment('Usuario que realiza cierre');
            $table->string('CIER_USERAUTORIZA', 37)->nullable()->comment('Usuario que autoriza cierre');
            $table->integer('CIER_ESTADO')->nullable()->comment('Estado de Transaccion: 0-Generado/Cierre 1-Aprobado 2-Finalizado/Inicio');

            $table->primary('CIER_ID');
            $table->unique('CIER_ID');
            $table->index('CIER_FECHA');
            $table->index('CIER_ESTADO');
            $table->index('SUCU_ID');
            $table->index('CIER_USERCAJERO');

            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
            $table->foreign('CIER_USERCAJERO')->references('EMPL_ID')->on('empleado');
            $table->foreign('CIER_USERAUTORIZA')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cierre');
    }
};
