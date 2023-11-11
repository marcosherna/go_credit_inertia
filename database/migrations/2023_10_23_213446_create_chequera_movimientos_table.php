<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('chequera_movimiento', function (Blueprint $table) {
            $table->string('CHEM_ID', 37)->comment('Codigo de movimiento, se recomienda un datestamp fecha+hora');
            $table->string('CHEQ_ID', 37)->comment('ID Chequera. Ref tabla chequera');
            $table->string('CHEM_NUMERO', 50)->comment('Numero de Cheque');
            $table->date('CHEM_FECHA')->comment('Fecha de Emision de Cheque');
            $table->string('CHEM_LUGAR', 100)->comment('Lugar de Emision del Cheque');
            $table->double('CHEM_MONTO', 10, 2)->default(0.00)->comment('Monto en numero');
            $table->string('CHEM_NOMBRE', 150)->comment('Nombre de Persona que se pagara cheque');
            $table->string('CHEM_MONTOLETRA', 255)->comment('Monto en letra');
            $table->string('CHEM_COMENTARIOS', 255)->nullable()->comment('Observaciones al cheque');
            $table->date('CHEM_FECHACAMBIO')->nullable()->comment('Fecha de Actualizacion');
            $table->string('USUA_ID', 37)->nullable()->comment('Usuario que realiza cheque');
            $table->integer('CHEM_ESTADO')->default(0)->comment('Estado cheque 0-Generado 1-Transito 2-Pagado 3-Anulado');

            $table->primary('CHEM_ID');
            $table->unique('CHEM_ID');
            $table->index('CHEM_NUMERO');
            $table->index('CHEM_FECHA');
            $table->index('CHEM_MONTO');
            $table->index('CHEQ_ID');
            $table->index('USUA_ID');

            $table->foreign('CHEQ_ID')->references('CHEQ_ID')->on('chequera');
            $table->foreign('USUA_ID')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chequera_movimiento');
    }
};
