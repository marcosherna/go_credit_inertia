<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tipo_variable', function (Blueprint $table) {
            $table->string('TIPV_ID', 37)->comment('ID Variable');
            $table->string('TIPV_NOMBRE', 30)->comment('Nombre Grupo Variable');
            $table->string('TIPV_DETALLE', 100)->default('')->comment('Detalle de Grupo');
            $table->integer('TIPV_ESTADO')->default(0)->comment('Estado Grupo: 0-Inactivo 1-Activo');

            $table->primary('TIPV_ID');
            $table->unique('TIPV_ID');
        });
    }


    public function down() {
        Schema::dropIfExists('tipo_variable');
    }
};
