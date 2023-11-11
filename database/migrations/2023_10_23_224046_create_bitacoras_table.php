<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->string('BITA_ID', 37)->comment('Correlativo de Registro');
            $table->tinyInteger('BITA_ACCION')->comment('Tipo de Accion: 0-guardar,1-modificar,2-eliminar,3-logueo,4-proceso,5-archivos,6-permiso');
            $table->string('BITA_REGISTROS', 100)->comment('Id registros afectados');
            $table->string('BITA_TABLA', 25)->comment('Nombre de la Tabla afectada');
            $table->string('USUA_LOGIN', 10)->nullable()->comment('ID Usuario Logueado.');
            $table->string('BITA_ESTATUS', 50)->nullable()->comment('Detalle para la Bitacora');
            $table->string('BITA_IP', 15)->comment('IP de PC que realiza la transaccion');
            $table->date('BITA_FECHA')->comment('Fecha de Transaccion');
            $table->time('BITA_HORA')->comment('Hora de Transaccion');

            $table->primary('BITA_ID');
            $table->unique('BITA_ID');
            $table->index('BITA_FECHA');
            $table->index('BITA_TABLA');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
};
