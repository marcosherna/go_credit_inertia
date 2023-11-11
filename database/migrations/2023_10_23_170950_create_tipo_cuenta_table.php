<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tipo_cuenta', function (Blueprint $table) {
            $table->string('TIPO_ID', 5)->comment('ID Tipo Cuenta');
            $table->string('TIPO_NOMBRE', 50)->comment('Nombre de Tipo');
            $table->integer('TIPO_ESTADO')->default(1)->comment('Estado. 0-Inactivo 1-Activo');

            $table->primary('TIPO_ID');
            $table->unique('TIPO_ID');
            $table->index('TIPO_NOMBRE');
        });
    }

    public function down()     {
        Schema::dropIfExists('tipo_cuenta');
    }
};
