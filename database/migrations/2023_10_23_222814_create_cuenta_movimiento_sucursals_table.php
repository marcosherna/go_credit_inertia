<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('cuenta_movimiento_sucursal', function (Blueprint $table) {
            $table->string('CUEM_ID', 37)->comment('ID de Registro');
            $table->string('CUEN_ID', 37)->comment('Cuenta Propietaria Ref tabla cuenta_sucursal');
            $table->string('PART_ID', 37)->default('')->comment('ID Partida Contable. Ref. tabla partida');
            $table->date('CUEM_FECHA')->comment('Fecha de Movimiento');
            $table->time('CUEM_HORA')->comment('Hora de Movimiento');
            $table->integer('CUEM_TIPOMOV')->comment('Tipo Registro: 0-Creacion Bolsa 1-Aporte Capital 2-Desembolso Credito 3-Pago Cuota 4-Pago Interes 5-Capitalizacion');
            $table->double('CUEM_SALDOINI', 8, 2)->comment('Saldo Anterior');
            $table->double('CUEM_ABONO', 8, 2)->comment('Abonos a cuenta');
            $table->double('CUEM_CARGO', 8, 2)->comment('Cargos a cuenta');
            $table->double('CUEM_SALDOFIN', 8, 2)->comment('Saldo Final');
            $table->string('CUEM_DETALLE', 200)->comment('Detalle del Movimiento');
            $table->integer('CUEM_ESTADO')->comment('Estado Transaccion: 0-Anulada 1-Aplicada 2-Flotante');
            $table->string('USUA_LOGIN', 37)->nullable()->comment('Usuario que realiza Transaccion');

            $table->primary('CUEM_ID');
            $table->unique('CUEM_ID');
            $table->index('CUEM_FECHA');
            $table->index('CUEM_DETALLE');
            $table->index('CUEN_ID');
            $table->index('PART_ID');
            $table->index('USUA_LOGIN');

            $table->foreign('CUEN_ID')->references('CUEN_ID')->on('cuenta_sucursal');
            $table->foreign('PART_ID')->references('PART_ID')->on('partida');
            $table->foreign('USUA_LOGIN')->references('USUA_LOGIN')->on('usuarios');
        });
    }

    public function down() {
        Schema::dropIfExists('cuenta_movimiento_sucursal');
    }
};
