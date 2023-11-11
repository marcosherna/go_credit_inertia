<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referencia', function (Blueprint $table) {
            $table->string('REFE_ID', 37)->comment('ID Referencia');
            $table->string('SOLI_ID', 37)->comment('ID Solicitud -> Ref. Tabla Solicitud');
            $table->string('REFE_NOMBRES', 100)->comment('Nombres de la referencia');
            $table->string('REFE_DIRECCION', 200)->comment('Direccion de la Referencia');
            $table->string('REFE_PARENTESCO', 30)->comment('Parentesco');
            $table->string('REFE_TELEFONO', 12)->comment('Telefono Contacto');
            $table->string('REFE_DUI', 12)->nullable()->comment('Numero de Dui');
            $table->string('REFE_MAIL', 200)->nullable()->comment('Correo Electronico');

            $table->primary('REFE_ID');
            $table->unique('REFE_ID');
            $table->index('REFE_NOMBRES');
            $table->index('REFE_PARENTESCO');
            $table->index('REFE_TELEFONO');
            $table->index('SOLI_ID');

            $table->foreign('SOLI_ID')->references('SOLI_ID')->on('solicitud');
        });
    }

    public function down() {
        Schema::dropIfExists('referencia');
    }
};
