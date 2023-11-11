<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('USUA_LOGIN', 250)->comment('Id Usuario');
            $table->string('USUA_PASS', 512)->comment('Pass');
            $table->string('PERF_ID', 37)->default('0')->comment('Ref. Tabla Perfiles - ID Perfil');
            $table->string('EMPL_ID', 37)->nullable()->comment('ID Empleado');
            $table->integer('USUA_ESTADO')->default(0)->comment('Estado. 0-Bloquado 1-Activo 2-Pendiente 3-Bloqueo Seguridad');

            $table->primary('USUA_LOGIN');
            $table->unique('USUA_LOGIN');
            $table->index('USUA_PASS');
            $table->index('PERF_ID');
            $table->index('EMPL_ID');

            $table->foreign('PERF_ID')->references('PERF_ID')->on('perfil');
            $table->foreign('EMPL_ID')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down() {
        Schema::dropIfExists('usuarios');
    }
};
