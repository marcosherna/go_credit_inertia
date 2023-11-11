<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()  {
        Schema::create('cuenta_sucursal', function (Blueprint $table) {
            $table->string('CUEN_ID', 37)->comment('Id de Cuenta');
            $table->string('CUEN_CONTA', 10)->nullable()->comment('Codigo Contable');
            $table->string('CUEN_NOMBRE', 100)->comment('Nombre de la Cuenta');
            $table->double('CUEN_SALDO', 8, 2)->comment('Saldo de la cuenta');
            $table->integer('CUEN_TIPO')->comment('Tipo cuenta: 0->Generales 1->Caja');
            $table->integer('CUEN_CLASIF')->comment('Clasificacion 0-Deudor 1-Acreedor');
            $table->integer('CUEN_CUENTA')->comment('Tipo de cuenta 1-Activo 2-Pasivo 3-Patrimonio 4-CostosGastos 5-Ingresos 6-Liquidadoras');
            $table->integer('CUEN_MODO')->default(0)->comment('Modo de Cuenta. 0-Resumen 1-Detalle');
            $table->string('CUEN_PADRE', 10)->nullable()->comment('Cuenta Padre');
            $table->string('SUCU_ID', 37)->comment('Sucursal Propietaria Cuenta');
            $table->date('CUEN_FECHA')->nullable()->comment('Fecha de Creacion');
            $table->time('CUEN_HORA')->nullable()->comment('Hora de Creacion');
            $table->integer('CUEN_ESTADO')->comment('Estado de Cuenta 0-Bloqueada 1-Activa');

            $table->primary('CUEN_ID');
            $table->unique('CUEN_ID');
            $table->index('CUEN_CONTA');
            $table->index('CUEN_NOMBRE');
            $table->index('CUEN_PADRE');
            $table->index('CUEN_CLASIF');
            $table->index('SUCU_ID');

            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
        });
    }

    public function down() {
        Schema::dropIfExists('cuenta_sucursal');
    }
};
