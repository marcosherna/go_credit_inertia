<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('municipio', function (Blueprint $table) {
            $table->string('MUNI_ID', 37)->primary();
            $table->string('MUNI_NOMBRE', 30);
            $table->string('DEPA_ID', 37);
            $table->string('PAIS_ID', 37);
            $table->integer('MUNI_ESTADO')->default(0);

            // Índices y claves foráneas
            $table->unique('MUNI_ID');
            $table->index('MUNI_NOMBRE');
            $table->index('MUNI_ESTADO');
            $table->index('DEPA_ID');
            $table->index('PAIS_ID');

            $table->foreign('DEPA_ID')
                ->references('DEPA_ID')
                ->on('departamento')
                ->onDelete('cascade');

            $table->foreign('PAIS_ID')
                ->references('PAIS_ID')
                ->on('pais');
        });
    }

    public function down() {
        Schema::dropIfExists('municipio');
    }
};
