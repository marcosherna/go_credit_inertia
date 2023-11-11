<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('cierre_detalle', function (Blueprint $table) {
            $table->string('CIER_ID', 37)->comment('ID Cierre. Ref. tabla cierre');
            $table->string('CIED_CORR', 5)->comment('Correlativo de Item');
            $table->string('CIED_REF', 100)->default('')->comment('Nombre Referencia');
            $table->string('CIED_CONCEPTO', 255)->default('')->comment('Detalle de Item');
            $table->double('CIED_CANTIDAD', 10, 0)->default(0)->comment('Cantidad Reportada');
            $table->double('CIED_UNIDAD', 10, 2)->default(0.00)->comment('Unidad Valor');
            $table->double('CIED_MONTO', 10, 2)->default(0.00)->comment('Total Cantidad por Valor');

            $table->primary(['CIER_ID', 'CIED_CORR']);
            $table->unique(['CIER_ID', 'CIED_CORR']);
            $table->index('CIED_REF');

            $table->foreign('CIER_ID')->references('CIER_ID')->on('cierre');
        });
    }

    public function down() {
        Schema::dropIfExists('cierre_detalle');
    }
};
