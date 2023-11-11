<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->string('TRAN_ID', 37)->comment('ID Transaccion');
            $table->string('TIPT_ID', 37)->comment('Tipo de Transaccion. Ref. Tipo_Transaccion');
            $table->date('TRAN_FECHA')->nullable()->comment('Fecha de Transaccion');
            $table->time('TRAN_HORA')->nullable()->comment('Hora de Transaccion');
            $table->double('TRAN_MONTO', 10, 2)->default(0.00)->comment('Monto de Transaccion');
            $table->string('TRAN_DETALLE', 200)->default('')->comment('Detalle de la Transaccion');
            $table->string('TRAN_REFERENCIA', 100)->default('')->comment('Codigos de Referencia');
            $table->string('TRAN_RESPUESTA', 100)->default('')->comment('Mensaje de respuesta servidores');
            $table->integer('TRAN_ESTADO')->default(0)->comment('Codigo Respuesta: 00-Exitosa 99-Fallida');
            $table->string('TRAN_USUARIO', 255)->nullable()->comment('Usuario que realiza Transaccion');

            $table->unique('TRAN_ID');
            $table->foreign('TIPT_ID')->references('TIPT_ID')->on('tipo_transaccion');
            $table->index('TRAN_FECHA');
            $table->index('TRAN_HORA');
            $table->index('TRAN_MONTO');
            $table->index('TRAN_RESPUESTA');
        });
    }
    public function down() {
        Schema::dropIfExists('transacciones');
    }
};
