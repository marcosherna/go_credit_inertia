<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fiadores', function (Blueprint $table) {
            $table->string('SOLI_ID', 37)->comment('ID Solicitud ->Ref. Tabla Solicitudes');
            $table->string('CLIE_ID',37)->comment('ID Cliente -> Ref. Tabla Clientes');
            $table->date('FIAD_FECHA')->comment('Fecha de Registro');
            $table->string('EMPL_ID', 37)->comment('ID Empleado - Ref. tabla empleados');

            $table->primary(['SOLI_ID', 'CLIE_ID']);
            $table->unique(['SOLI_ID', 'CLIE_ID']);
            $table->index('CLIE_ID');
            $table->index('EMPL_ID');

            $table->foreign('SOLI_ID')->references('SOLI_ID')->on('solicitud');
            $table->foreign('CLIE_ID')->references('CLIE_ID')->on('cliente');
            $table->foreign('EMPL_ID')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down() {
        Schema::dropIfExists('fiadores');
    }
};
