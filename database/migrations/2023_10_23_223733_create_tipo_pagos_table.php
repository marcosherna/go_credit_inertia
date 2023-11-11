<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tipo_pago', function (Blueprint $table) {
            $table->string('TIPP_ID', 37)->comment('ID Tipo de Pago');
            $table->string('TIPP_NOMBRE', 30)->comment('Nombre Tipo de Pago');
            $table->tinyInteger('TIPP_ESTADO')->default(0)->comment('Estado de Tipo de Pago');

            $table->primary('TIPP_ID');
            $table->unique('TIPP_ID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_pago');
    }
};
