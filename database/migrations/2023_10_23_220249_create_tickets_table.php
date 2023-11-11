<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('TICK_ID', 37)->comment('Id Ticket');
            $table->date('TICK_FECHACREACION')->comment('Fecha de creacion del ticket');
            $table->time('TICK_HORACREACION')->comment('Hora de creacion del ticket');
            $table->date('TICK_FECHAAPROB')->nullable()->comment('Fecha de aprobacion del ticket');
            $table->time('TICK_HORAAPROB')->nullable()->comment('Hora de aprobacion del ticket');
            $table->string('TTICK_ID', 37)->comment('Tipo de ticket. Ref tabla tipo_ticket');
            $table->string('TICK_USUARIO', 37)->comment('Usuario que realizo la solicitud');
            $table->string('TICK_USUAAUTORIZA', 37)->nullable()->comment('Usuario que autoriza la solicitud');
            $table->string('TICK_REFERENCIA', 150)->comment('Referencia');
            $table->string('TICK_COMENTARIOS', 150)->nullable()->comment('Comentarios del ticket');
            $table->integer('TICK_ESTADO')->default(0)->comment('Estado de Solicitud. 0-Pendiente 1-Aprobado 2-rechazado');

            $table->primary('TICK_ID');
            $table->unique('TICK_ID');
            $table->index('TICK_FECHACREACION');
            $table->index('TICK_FECHAAPROB');
            $table->index('TICK_ESTADO');
            $table->index('TTICK_ID');
            $table->index('TICK_USUARIO');

            $table->foreign('TTICK_ID')->references('TTICK_ID')->on('tipo_ticket');
            $table->foreign('TICK_USUARIO')->references('EMPL_ID')->on('empleado');
            $table->foreign('TICK_USUAAUTORIZA')->references('EMPL_ID')->on('empleado');
        });
    }
    public function down() {
        Schema::dropIfExists('tickets');
    }
};
