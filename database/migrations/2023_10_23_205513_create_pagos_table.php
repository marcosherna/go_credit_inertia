<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->string('PAGO_ID', 37)->comment('ID del Pago');
            $table->date('PAGO_FECHA')->nullable()->comment('Fecha de Pago');
            $table->time('PAGO_HORA')->nullable()->comment('Pago Hora');
            $table->string('SOLI_ID', 37)->default('')->comment('Id Solicitud. Ref. Tabla solicitud');
            $table->double('PAGO_MONTO', 10, 2)->unsigned()->default(0.00)->comment('Cantidad del Pago');
            $table->double('PAGO_CAPITAL', 10, 2)->unsigned()->default(0.00)->comment('Capital Abonado');
            $table->double('PAGO_INTERES', 10, 2)->unsigned()->default(0.00)->comment('Interes Abonado');
            $table->double('PAGO_MORA', 10, 2)->unsigned()->default(0.00)->comment('Saldo Moratorio');
            $table->double('PAGO_SEGURO', 10, 2)->unsigned()->default(0.00)->comment('Pago Cuota Seguro');
            $table->double('PAGO_OTRO', 10, 2)->unsigned()->default(0.00)->comment('Otro Pago');
            $table->double('PAGO_IVA', 10, 2)->default(0.00)->comment('IVA del PagoInteress');
            $table->double('PAGO_ANTERIOR', 10, 2)->default(0.00)->comment('Saldo Anterior CAPITAL');
            $table->double('PAGO_SALDO', 10, 2)->unsigned()->default(0.00)->comment('Nuevo Saldo CAPITAL');
            $table->string('EMPL_ID', 37)->default('')->comment('ID Empleado que realiza el Pago');
            $table->string('PAGO_REFERENCIA', 100)->default('')->comment('Referencia del Pago');

            $table->primary('PAGO_ID');
            $table->unique('PAGO_ID');
            $table->index('PAGO_FECHA');
            $table->index('PAGO_MONTO');
            $table->index('PAGO_REFERENCIA');
            $table->index('SOLI_ID');
            $table->index('EMPL_ID');

            $table->foreign('SOLI_ID')->references('SOLI_ID')->on('solicitud');
            $table->foreign('EMPL_ID')->references('EMPL_ID')->on('empleado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pago');
    }
};
