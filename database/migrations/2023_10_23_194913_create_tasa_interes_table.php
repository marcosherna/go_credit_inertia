<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tasa_interes', function (Blueprint $table) {
            $table->string('TASA_ID', 37)->primary()->comment('ID Tasa de Interes');
            $table->string('TASA_VALOR', 8)->comment('Valor Tasa de Interes');
            $table->tinyInteger('TASA_TIPO')->default(0)->comment('Tipo de Tasa de Interes. 0-Unica 1-Mensual 2-Anual');
            $table->tinyInteger('TASA_ESTADO')->default(0)->comment('Estado Tasa. 0-Inactivo 1-Activo');

            $table->unique('TASA_ID');
            $table->index('TASA_VALOR');
        });

    }

    public function down() {
        Schema::dropIfExists('tasa_interes');
    }
};
