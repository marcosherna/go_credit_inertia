<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruta', function (Blueprint $table) {
            $table->string('RUTA_ID', 37)->comment('ID de Ruta');
            $table->string('RUTA_NOMBRE', 30)->comment('Nombre de Ruta');
            $table->string('RUTA_REFERENCIA', 5)->comment('Referencia de Ruta. Ciudad+Sector+Corr');
            $table->string('RUTA_DETALLE', 255)->default('')->comment('Detalle de Ruta');
            $table->string('SUCU_ID', 37)->nullable()->comment('ID Sucursal. Ref. Tabla sucursal');
            $table->integer('RUTA_ESTADO', false, false)->default(0)->comment('Estado. 0-Inactivo 1-Activo');

            $table->primary('RUTA_ID');
            $table->unique('RUTA_ID');
            $table->index('RUTA_NOMBRE');
            $table->index('RUTA_ESTADO');
            $table->index('SUCU_ID');

            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
        });
    }

    public function down() {
        Schema::dropIfExists('ruta');
    }
};
