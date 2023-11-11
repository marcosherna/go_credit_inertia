<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('tipo_empresa', function (Blueprint $table) {
            $table->string('TIPO_ID', 37)->primary();
            $table->string('TIPO_NOMBRE', 30);
            $table->integer('TIPO_ESTADO')->default(0);

            // Índices y claves
            $table->unique('TIPO_ID');
            $table->index('TIPO_ESTADO');
        });
    }

    public function down() {
        Schema::dropIfExists('tipo_empresa');
    }
};
