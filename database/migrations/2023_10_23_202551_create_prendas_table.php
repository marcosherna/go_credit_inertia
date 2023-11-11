<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prendas', function (Blueprint $table) {
            $table->string('PREN_ID', 37)->comment('ID Prenda');
            $table->string('SOLI_ID', 37)->comment('ID Solicitud -> Ref. Tabla Solicitudes');
            $table->string('PREN_NOMBRE', 30)->comment('Nombre de Prenda');
            $table->string('PREN_MARCA', 30)->comment('Marca de Prenda');
            $table->string('PREN_MODELO', 30)->nullable()->comment('Modelo de Prenda');
            $table->double('PREN_PRECIO', 10, 2)->comment('Precio de Referencia de la Prenda');
            $table->double('PREN_PRECIOGARANTA', 10, 2)->comment('Precio Valuado de la Garantia');
            $table->string('PREN_DETALLE', 100)->nullable()->comment('Detalle de Prenda');
            $table->string('PREN_ANOFABRICACION', 4)->nullable()->comment('Ano de Fabricacion');
            $table->string('PREN_IMAGEN', 200)->nullable()->comment('Imagen de Referencia de la Garantia');

            $table->primary('PREN_ID');
            $table->unique('PREN_ID');
            $table->index('PREN_NOMBRE');
            $table->index('PREN_MARCA');
            $table->index('PREN_DETALLE');
            $table->index('SOLI_ID');

            $table->foreign('SOLI_ID')->references('SOLI_ID')->on('solicitud');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prendas');
    }
};
