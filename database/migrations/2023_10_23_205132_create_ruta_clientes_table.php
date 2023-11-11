<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('ruta_cliente', function (Blueprint $table) {
            $table->string('RUTA_ID', 37)->comment('ID Ruta');
            $table->string('CLIE_ID', 37)->comment('ID Cliente');

            $table->primary(['RUTA_ID', 'CLIE_ID']);
            $table->unique(['RUTA_ID', 'CLIE_ID']);
            $table->index('CLIE_ID');

            $table->foreign('RUTA_ID')->references('RUTA_ID')->on('ruta');
            $table->foreign('CLIE_ID')->references('CLIE_ID')->on('cliente');
        });

    }

    public function down() {
        Schema::dropIfExists('ruta_cliente');
    }
};
