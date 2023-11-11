<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_ticket', function (Blueprint $table) {
            $table->string('TTICK_ID', 37)->comment('Id Tipo Ticket');
            $table->string('TTICK_NOMBRE', 50)->comment('Nombre del tipo de ticket');
            $table->string('TTICK_DETALLE', 150)->nullable()->comment('Detalle del tipo de ticket');

            $table->primary('TTICK_ID');
            $table->unique('TTICK_ID');
        });
    }

    public function down(){
        Schema::dropIfExists('tipo_ticket');
    }
};
