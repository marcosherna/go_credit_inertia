<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo', function (Blueprint $table) {
            $table->string('MODU_ID', 37)->comment('ID Modulo');
            $table->string('MODU_NOMBRE', 30)->comment('Nombre Modulo');
            $table->string('MODU_DETALLE', 100)->comment('Descripcion Modulo');
            $table->integer('MODU_TIPO')->default(0)->comment('Tipo Modulo. 0-menu 1-modulo');
            $table->integer('MODU_ESTADO')->comment('Estado del Modulo: 0-Inactivo 1-Activo 2-Descontinuado');

            $table->unique('MODU_ID');
            $table->index('MODU_NOMBRE');
            $table->index('MODU_ESTADO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulo');
    }
};
