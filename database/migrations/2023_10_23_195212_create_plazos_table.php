<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() {
        Schema::create('plazo', function (Blueprint $table) {
            $table->string('PLAZ_ID', 37)->primary()->comment('ID Plazo');
            $table->string('PLAZ_NOMBRE', 30)->comment('Nombre del Plazo');
            $table->integer('PLAZ_VALOR')->default(0)->comment('Plazo Numerico.');
            $table->tinyInteger('PLAZ_ESTADO')->default(0)->comment('Estado registro 1=Activo 0 = Bloqueado');

            $table->unique('PLAZ_ID');
            $table->index('PLAZ_NOMBRE');
            $table->index('PLAZ_ESTADO');
        });
    }

    public function down() {
        Schema::dropIfExists('plazo');
    }
};
