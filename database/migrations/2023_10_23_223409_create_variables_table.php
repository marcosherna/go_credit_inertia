<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->string('VARI_ID', 37)->comment('ID Variable');
            $table->string('VARI_NOMBRE', 30)->comment('Nombre Variable');
            $table->string('VARI_VALOR', 50)->comment('Valor de la Variable');
            $table->string('VARI_DETALLE', 100)->nullable()->comment('Detalle de Variable');
            $table->string('TIPV_ID', 37)->comment('Tipo de Variable Ref. Tipo_variable');

            $table->primary('VARI_ID');
            $table->unique('VARI_ID');
            $table->index('VARI_NOMBRE');
            $table->index('VARI_VALOR');
            $table->index('TIPV_ID');

            $table->foreign('TIPV_ID')->references('TIPV_ID')->on('tipo_variable');
        });
    }

    public function down() {
        Schema::dropIfExists('variables');
    }
};
