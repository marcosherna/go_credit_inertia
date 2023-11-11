<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('empleado', function (Blueprint $table) {
            $table->string('EMPL_ID', 37)->comment('ID Empleado');
            $table->string('EMPL_NOMBRE', 50)->comment('Primer Nombre');
            $table->string('EMPL_NOMBRE2', 50)->nullable()->comment('Segundo Nombre');
            $table->string('EMPL_APELLIDO', 50)->comment('Primer Apellido');
            $table->string('EMPL_APELLIDO2', 50)->nullable()->comment('Segundo Apellido');
            $table->string('EMPL_APELLIDO3', 50)->nullable()->comment('Tercer Apellido');
            $table->string('EMPL_FOTO', 200)->nullable()->comment('Fotografia del Empleado');
            $table->integer('EMPL_SEXO', false, false)->default(0)->comment('Sexo: 0-No Definido 1-Masculino 2-Femenino');
            $table->string('ESTA_ID', 37)->comment('Estado Civil- Ref. Tabla Estdo Civil');
            $table->string('PAIS_NAC', 37)->nullable()->comment('Pais de Nacimiento');
            $table->string('DEPA_NAC', 37)->nullable()->comment('Departamento de Nacimiento');
            $table->date('EMPL_FECHANAC')->nullable()->comment('Fecha de Nacimiento');
            $table->string('EMPL_DOCIDEN', 20)->nullable()->comment('Documento de Identidad');
            $table->string('EMPL_DOCFISCAL', 20)->nullable()->comment('NIT Empleado');
            $table->string('EMPL_PASAPORTE', 20)->nullable()->comment('Numero de Pasaporte');
            $table->string('EMPL_ISSS', 20)->nullable()->comment('Numero de Seguro Social');
            $table->string('EMPL_NUP', 20)->nullable()->comment('Numero Fondo de Pensiones');
            $table->integer('EMPL_ANTECEDENTES', false, false)->default(0)->comment('Antecedentes Penales 0-No 1-Si');
            $table->string('PAIS_ID', 37)->comment('ID Pais. Ref. tabla -> pais');
            $table->string('DEPA_ID', 37)->comment('ID Departamento. Ref. Tabla -> departamento');
            $table->string('MUNI_ID', 37)->comment('ID Municipio. Ref. Tabla Municipio');
            $table->string('EMPL_DIRECCION', 100)->nullable()->comment('Direccion Empleado');
            $table->string('EMPL_TEL', 12)->nullable()->comment('Telefono Principal');
            $table->string('EMPL_TEL2', 12)->nullable()->comment('Telefono Alternativo');
            $table->string('EMPL_MAIL', 200)->nullable()->comment('Correo Empresarial');
            $table->string('EMPL_MAIL2', 200)->nullable()->comment('Correo Alternativo');
            $table->integer('EMPL_ESTADO', false, false)->comment('Estado de Cliente. 0-Bloqueado 1-Activo 2-Lista Negra');
            $table->string('SUCU_ID', 37)->comment('ID Sucursal. Ref. Tabla->sucursal');
            $table->string('EMPR_ID', 37)->comment('ID Empresa. Ref. tabla ->empresa');
            $table->string('USUA_LOGIN', 200)->nullable()->comment('Usuario que realiza el registro');
            $table->datetime('FECHA_CAMBIO')->nullable()->comment('Fecha de Afiliacion');

            $table->primary('EMPL_ID');
            $table->unique('EMPL_ID');
            $table->index('EMPL_NOMBRE');
            $table->index('EMPL_APELLIDO');
            $table->index('EMPL_DOCIDEN');
            $table->index('EMPL_ESTADO');
            $table->index('EMPL_TEL');
            $table->index('ESTA_ID');
            $table->index('PAIS_NAC');
            $table->index('DEPA_NAC');
            $table->index('PAIS_ID');
            $table->index('DEPA_ID');
            $table->index('MUNI_ID');
            $table->index('SUCU_ID');
            $table->index('EMPR_ID');

            $table->foreign('ESTA_ID')->references('ESTA_ID')->on('estado_civil');
            $table->foreign('PAIS_NAC')->references('PAIS_ID')->on('pais');
            $table->foreign('DEPA_NAC')->references('DEPA_ID')->on('departamento');
            $table->foreign('PAIS_ID')->references('PAIS_ID')->on('pais');
            $table->foreign('DEPA_ID')->references('DEPA_ID')->on('departamento');
            $table->foreign('MUNI_ID')->references('MUNI_ID')->on('municipio');
            $table->foreign('SUCU_ID')->references('SUCU_ID')->on('sucursal');
            $table->foreign('EMPR_ID')->references('EMPR_ID')->on('empresa');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('empleado');
    }
};
