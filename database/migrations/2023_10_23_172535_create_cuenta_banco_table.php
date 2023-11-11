<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('cuenta_banco', function (Blueprint $table) {
            $table->string('CUEB_NUMERO', 50)->comment('Numero de Cuenta Bancaria');
            $table->string('CUEB_DETALLE', 255)->comment('Descripcion de cuenta bancaria');
            $table->string('CUEN_ID', 37)->comment('ID Cuenta Contable. Ref. Tabla cuenta_sucursal');
            $table->string('BANC_ID', 37)->comment('ID Banco. Ref. tabla Banco');
            $table->string('TIPC_ID', 37)->comment('ID Tipo Cuenta. Ref. tabla tipo_cuenta');
            $table->integer('CUEB_ESTADO')->default(0)->comment('Estado cuenta 0-Inactivo 1-Activo');

            $table->primary('CUEB_NUMERO');
            $table->unique('CUEB_NUMERO');
            $table->index('CUEB_DETALLE');
            $table->index('CUEN_ID');
            $table->index('BANC_ID');
            $table->index('TIPC_ID');

            $table->foreign('CUEN_ID')->references('CUEN_ID')->on('cuenta_sucursal');
            $table->foreign('BANC_ID')->references('BANC_ID')->on('banco');
            $table->foreign('TIPC_ID')->references('TIPO_ID')->on('tipo_cuenta');
        });
    }

    public function down() {
        Schema::dropIfExists('cuenta_banco');
    }
};
