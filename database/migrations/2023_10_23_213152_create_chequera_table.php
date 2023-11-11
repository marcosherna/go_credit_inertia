<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chequera', function (Blueprint $table) {
            $table->string('CHEQ_ID', 37)->comment('ID Chequera');
            $table->string('CUEB_NUMERO', 50)->comment('ID de la cuenta bancaria');
            $table->double('CHEQ_DESDE', 50, 0)->default(0)->comment('Correlativo desde');
            $table->double('CHEQ_HASTA', 50, 0)->default(0)->comment('Correlativo hasta');
            $table->integer('CHEQ_CANTIDAD')->default(0)->comment('Cantidad de Cheques de la Chequera');
            $table->integer('CHEQ_PENDIENTES')->default(0)->comment('Cantidad de cheques en blanco');
            $table->string('CHEQ_REFERENCIA', 50)->comment('Identificador de Referencia');
            $table->date('CHEQ_FECHA')->comment('Fecha de Registro');
            $table->integer('CHEQ_GENERACION')->default(0)->comment('0-Manual 1-Auto');
            $table->double('CHEQ_VERIFICADOR', 50, 0)->default(0)->comment('Ultimo Cheque emitido');
            $table->integer('CHEQ_ESTADO')->default(0)->comment('0-Sellada 1-Activa 2-Terminada 3-Archivada');

            $table->primary('CHEQ_ID');
            $table->unique('CHEQ_ID');
            $table->index('CHEQ_FECHA');
            $table->index('CHEQ_ESTADO');
            $table->index('CUEB_NUMERO');

            $table->foreign('CUEB_NUMERO')->references('CUEB_NUMERO')->on('cuenta_banco');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chequera');
    }
};
