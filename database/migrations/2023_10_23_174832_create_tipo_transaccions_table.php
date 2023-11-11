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
        Schema::create('tipo_transaccion', function (Blueprint $table) {
            $table->string('TIPT_ID', 37)->comment('Tipo Transaccion ID - Service Code');
            $table->string('TIPT_NOMBRE', 50)->comment('Nombre Transaccion');
            $table->string('TIPT_DETALLE', 100)->default('')->comment('Detalle Transaccion');
            $table->string('COLE_ID', 37)->default('')->comment('ID Colector. Ref. Tabla Colector');
            $table->integer('TIPT_MOVIMIENTO')->nullable()->comment('0-Ingreso 1-Salida');
            $table->string('CUEN_ID', 37)->nullable()->comment('Cuenta Contable Relacionada. Ref. cuenta_sucursal');
            $table->integer('TIPT_FACTURABLE')->default(0)->comment('Si la transaccion separa IVA. 0-No 1-Si');
            $table->string('CUEN_FACTURAR', 37)->nullable()->comment('Cuenta contabla relacionada. Ref. cuenta_sucursal');
            $table->integer('TIPT_ESTADO')->default(0)->comment('Estado. 0-Inactivo 1-Activo');

            $table->unique('TIPT_ID');
            $table->foreign('COLE_ID')->references('COLE_ID')->on('colector');
            $table->foreign('CUEN_ID')->references('CUEN_ID')->on('cuenta_sucursal');
            $table->foreign('CUEN_FACTURAR')->references('CUEN_ID')->on('cuenta_sucursal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_transaccion');
    }
};
