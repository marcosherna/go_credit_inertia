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
        Schema::create('tipo_interes', function (Blueprint $table) {
            $table->string('TIPO_ID', 37)->primary()->comment('ID Tipo Interes');
            $table->string('TIPO_NOMBRE', 30)->comment('Nombre del Tipo de Interes');
            $table->string('TIPO_DESCRIPCION', 100)->default('')->comment('Descripción');
            $table->tinyInteger('TIPO_ESTADO')->default(0)->comment('Estado 0-Inactivo 1-Activo');

            // Puedes agregar más columnas si es necesario

            $table->unique('TIPO_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_interes');
    }
};
