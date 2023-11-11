<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('tipo_colector', function (Blueprint $table) {
            $table->string('TIPC_ID', 37)->comment('Id Categoria Colector');
            $table->string('TIPC_NOMBRE', 50)->comment('Nombre de Categoria');
            $table->string('TIPC_DETALLE', 255)->nullable()->comment('Descripcion de Colector');
            $table->integer('TIPC_ORDEN')->default(0)->comment('Orden de lista del colector');
            $table->integer('TIPC_ESTADO')->default(0)->comment('Estado 0-Inactivo 1-Activo');

            $table->unique('TIPC_ID');
        });
    }

    public function down() {
        Schema::dropIfExists('tipo_colector');
    }
};
