<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->string('EMPR_ID', 37)->primary();
            $table->string('EMPR_NOMBRE', 100);
            $table->string('EMPR_NOMCORTO', 30)->nullable();
            $table->string('EMPR_SLOGAN', 100)->nullable();
            $table->string('EMPR_LOGO', 100);
            $table->string('EMPR_DIRECCION', 100);
            $table->string('EMPR_TEL', 12);
            $table->string('EMPR_FAX', 12)->nullable();
            $table->string('EMPR_WEB', 200)->nullable();
            $table->string('TIPO_ID', 37);
            $table->string('EMPR_GERENTE', 100);
            $table->string('EMPR_GERENTEMAIL', 100);
            $table->string('EMPR_GERENTETEL', 12);
            $table->string('EMPR_TECNICO', 100);
            $table->string('EMPR_TECNICOMAIL', 100);
            $table->string('EMPR_TECNICOTEL', 12);
            $table->string('PAIS_ID', 37);
            $table->string('DEPA_ID', 37);
            $table->string('MUNI_ID', 37);
            $table->string('EMPR_PADRE', 10)->nullable();
            $table->integer('EMPR_ESTADO', false, false);

             // Índices y claves foráneas
             $table->unique('EMPR_ID');
             $table->index('EMPR_NOMBRE');
             $table->index('EMPR_TEL');
             $table->index('EMPR_GERENTE');
             $table->index('EMPR_ESTADO');
             $table->index('TIPO_ID');
             $table->index('PAIS_ID');
             $table->index('DEPA_ID');

            // Definición de claves foráneas
            $table->foreign('TIPO_ID')->references('TIPO_ID')->on('tipo_empresa');
            $table->foreign('PAIS_ID')->references('PAIS_ID')->on('pais');
            $table->foreign('DEPA_ID')->references('DEPA_ID')->on('departamento');

            // Restricciones y otras columnas aquí

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
};
