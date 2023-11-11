<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('pais', function (Blueprint $table) {
            $table->string('PAIS_ID', 37)->primary();
            $table->string('PAIS_NOMBRE', 30);
            $table->string('PAIS_ABREV', 5);
            $table->string('PAIS_CODAREA', 5);
            $table->string('PAIS_MONEDA', 30);
            $table->string('PAIS_MONSIMBOLO', 5);
            $table->string('PAIS_MONABREV', 5);
            $table->integer('PAIS_ESTADO')->default(0);

            // Índices
            $table->unique('PAIS_ID');
            $table->index('PAIS_NOMBRE');
            $table->index('PAIS_MONEDA');
            $table->index('PAIS_ESTADO');
        });
    }

    public function down() {
        Schema::dropIfExists('pais');
    }
};
