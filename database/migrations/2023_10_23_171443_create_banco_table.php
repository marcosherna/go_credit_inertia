<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('banco', function (Blueprint $table) {
            $table->string('BANC_ID', 37)->comment('ID Banco');
            $table->string('BANC_NOMBRE', 100)->comment('Nombre banco');
            $table->string('BANC_DETALLE', 255)->nullable()->comment('Descripcion del Banco');
            $table->string('SUCU_ID', 37)->comment('ID Sucursal de Registro. Ref. tabla Sucursal');
            $table->integer('BANC_ESTADO')->comment('Estado Banco 0-Inactivo 1-Activo');

            $table->primary('BANC_ID');
            $table->unique('BANC_ID');
            $table->index('BANC_NOMBRE');
            $table->index('BANC_ESTADO');
            $table->index('SUCU_ID');

            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
        });
    }

    public function down()     {
        Schema::dropIfExists('banco');
    }
};
