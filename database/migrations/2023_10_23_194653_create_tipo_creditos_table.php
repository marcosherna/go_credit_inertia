<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('tipo_credito', function (Blueprint $table) {
            $table->string('TIPO_ID', 37)->primary()->comment('ID de Registro');
            $table->string('TIPO_NOMBRE', 50)->comment('Nombre del Tipo de Credito');
            $table->string('TIPO_ABREV', 3)->comment('Abreviatura del Tipo');
            $table->tinyInteger('TIPO_ESTADO')->default(0)->comment('Estado Credito 0-Inactivo 1-Activo');

            $table->unique('TIPO_ID');
        });
    }

    public function down() {
        Schema::dropIfExists('tipo_credito');
    }
};
