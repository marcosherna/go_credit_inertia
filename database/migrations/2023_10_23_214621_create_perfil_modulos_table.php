<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('perfil_modulo', function (Blueprint $table) {
            $table->string('PERM_ID', 37)->comment('ID Registro');
            $table->string('PERF_ID', 37)->comment('ID Perfil - Ref. Tabla Perfil');
            $table->string('MODU_ID', 37)->comment('ID Modulo. Ref. Tabla modulo');
            $table->integer('PERM_ACCESAR')->default(0)->comment('Mostrar Enlace. 0->No 1->Si');
            $table->integer('PERM_VER')->default(0)->comment('Ver Registros. 0->No 1->Si');
            $table->integer('PERM_NUEVO')->default(0)->comment('Crear Registros. 0->No 1->Si');
            $table->integer('PERM_EDITAR')->default(0)->comment('Editar Registros. 0->No 1->Si');
            $table->integer('PERM_BORRAR')->default(0)->comment('Eliminar Registros. 0->No 1->Si');
            $table->integer('PERM_PROCESAR')->default(0)->comment('Procesar Registros. 0->No 1->Si');
            $table->integer('PERM_LIMITARUSUARIO')->default(0)->comment('Ver Datos solo del Usuario logueado. 0->No 1->Si');
            $table->integer('PERM_REPORTES')->default(0)->comment('Ver Reportes. 0->No 1->Si');
            $table->integer('PERM_EXPLORAR')->default(0)->comment('Explorar Registros. 0->No 1->Si');

            $table->unique('PERM_ID');
            $table->index('PERF_ID');
            $table->index('MODU_ID');

            $table->foreign('PERF_ID')->references('PERF_ID')->on('perfil');
            $table->foreign('MODU_ID')->references('MODU_ID')->on('modulo');
        });
    }
    public function down()
    {
        Schema::dropIfExists('perfil_modulo');
    }
};
