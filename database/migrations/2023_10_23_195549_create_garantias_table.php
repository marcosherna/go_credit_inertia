<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('garantia', function (Blueprint $table) {
            $table->string('GARA_ID', 37)->primary()->comment('ID Garantia');
            $table->string('GARA_NOMBRE', 30)->comment('Nombre de Garantia');
            $table->tinyInteger('GARA_ESTADO')->default(1)->comment('Estado garantia 0-Inactiva 1-Activa 9-Eliminada');

            // Puedes agregar más columnas si es necesario

            $table->unique('GARA_ID');
            $table->index('GARA_NOMBRE');
        });
    }

    public function down() {
        Schema::dropIfExists('garantia');
    }
};
