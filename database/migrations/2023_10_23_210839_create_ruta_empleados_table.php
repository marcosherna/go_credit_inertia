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
        Schema::create('ruta_empleado', function (Blueprint $table) {
            $table->string('RUTA_ID', 37)->comment('ID de Ruta');
            $table->string('EMPL_ID', 37)->comment('ID Empleado');

            $table->primary(['RUTA_ID', 'EMPL_ID']);
            $table->unique(['RUTA_ID', 'EMPL_ID']);
            $table->index('RUTA_ID');
            $table->index('EMPL_ID');

            $table->foreign('RUTA_ID')->references('RUTA_ID')->on('ruta');
            $table->foreign('EMPL_ID')->references('EMPL_ID')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruta_empleado');
    }
};
