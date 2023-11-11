<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->string('PERF_ID', 37)->comment('ID del Perfil');
            $table->string('PERF_NOMBRE', 30)->comment('Nombre del Perfil');
            $table->integer('PERF_ESTADO')->comment('Estado del Perfil. 0->Inactivo 1-> Activo');

            $table->unique('PERF_ID');
            $table->index('PERF_NOMBRE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil');
    }
};
