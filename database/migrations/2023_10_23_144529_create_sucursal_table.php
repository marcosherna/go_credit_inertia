<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->string('SUCU_ID', 37)->comment('Codigo de Sucursal');
            $table->string('SUCU_NOMBRE', 30)->comment('Nombre de Sucursal');
            $table->string('MUNI_ID', 37)->comment('ID Municipio. Ref. tabla municipio');
            $table->string('SUCU_DIRECCION', 100)->comment('Direccion Sucursal');
            $table->string('SUCU_TEL', 12)->nullable()->comment('Numero de Telefono');
            $table->string('SUCU_MAIL', 200)->nullable()->comment('Correo Electronico de la Sucursal');
            $table->string('SUCU_IMAGEN', 255)->nullable()->comment('Imagen de Comercio');
            $table->string('SUCU_IMAGEN2', 255)->nullable()->comment('Imagen alterna');
            $table->string('EMPR_ID', 37)->comment('ID Empresa propietaria');
            $table->integer('SUCU_ESTADO', false, false)->default(1)->comment('Estado sucursal');

            $table->primary('SUCU_ID');
            $table->unique('SUCU_ID');
            $table->index('SUCU_NOMBRE');
            $table->index('SUCU_TEL');
            $table->index('SUCU_ESTADO');
            $table->index('MUNI_ID');
            $table->index('EMPR_ID');

            $table->foreign('MUNI_ID')->references('MUNI_ID')->on('municipio');
            $table->foreign('EMPR_ID')->references('EMPR_ID')->on('empresa');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('sucursal');
    }
};
