<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {

        Schema::create('departamento', function (Blueprint $table) {
            $table->string('DEPA_ID', 37)->primary();
            $table->string('DEPA_NOMBRE', 30);
            $table->integer('DEPA_REGION');
            $table->string('PAIS_ID', 37);
            $table->integer('DEPA_ESTADO')->default(1);

            // Índices y claves foráneas
            $table->unique('DEPA_ID');
            $table->index('DEPA_NOMBRE');
            $table->index('DEPA_ESTADO');
            $table->index('PAIS_ID');

            $table->foreign('PAIS_ID')
                ->references('PAIS_ID')
                ->on('pais');
        });
    }

    public function down() {
        Schema::dropIfExists('departamento');
    }
};
