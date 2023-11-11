<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('forma_pago', function (Blueprint $table) {
            $table->string('FORM_ID', 37)->primary()->comment('ID Forma Pago');
            $table->string('FORM_NOMBRE', 30)->comment('Nombre de Forma de Pago');
            $table->integer('FORM_VALOR')->default(0)->comment('Forma de Pago en días');
            $table->tinyInteger('FORM_ESTADO')->default(1)->comment('Estado Registro. 1-Activo 0-Inactivo');

            // Puedes agregar más columnas si es necesario

            $table->unique('FORM_ID');
            $table->index('FORM_NOMBRE');
        });
    }

    public function down() {
        Schema::dropIfExists('forma_pago');
    }
};
