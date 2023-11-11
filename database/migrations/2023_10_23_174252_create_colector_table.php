<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('colector', function (Blueprint $table) {
            $table->string('COLE_ID', 37)->comment('ID Colector en Sistema');
            $table->string('COLE_NOMBRE', 100)->nullable()->comment('Nombre del Colector');
            $table->string('COLE_NOMCORTO', 30)->default('')->comment('Nombre Corto Colector');
            $table->string('COLE_LOGO', 255)->nullable()->comment('Logo del Colector');
            $table->string('COLE_REF', 6)->default('')->comment('ID Referencia. Tabla tipo Transaccion');
            $table->string('COLE_DETALLE', 255)->default('')->comment('Detalle de Colector');
            $table->integer('COLE_FORMULARIO')->default(1)->comment('Formulario a Utilizar.1-Estandar');
            $table->string('TIPC_ID', 37)->nullable()->comment('Tipo Colector. Ref tabla tipo_colector');
            $table->integer('COLE_ESTADO')->default(0)->comment('Estado del Campo. 0-Inactivo 1-Activo');

            $table->unique('COLE_ID');
            $table->foreign('TIPC_ID')->references('TIPC_ID')->on('tipo_colector');
        });
    }

    public function down() {
        Schema::dropIfExists('colector');
    }
};
