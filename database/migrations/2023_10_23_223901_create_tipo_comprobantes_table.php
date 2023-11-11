<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_comprobante', function (Blueprint $table) {
            $table->string('TIPC_ID', 37)->comment('ID Documento de Venta');
            $table->string('TIPC_NOMBRE', 30)->comment('Nombre Documento de Venta');
            $table->string('TIPC_DETALLE', 100)->comment('Descripción de Documento');
            $table->tinyInteger('TIPC_FISCAL')->default(1)->comment('Documento es Fiscal 0-No 1-Si');
            $table->tinyInteger('TIPC_ESTADO')->default(1)->comment('Estado de Documento 0-Inactivo 1-Activo');

            $table->primary('TIPC_ID');
            $table->unique('TIPC_ID');
        });
    }

    public function down() {
        Schema::dropIfExists('tipo_comprobante');
    }
};
