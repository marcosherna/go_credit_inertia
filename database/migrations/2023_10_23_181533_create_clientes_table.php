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
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('CLIE_ID', 37)->comment('ID Cliente');
            $table->string('CLIE_NOMBRE', 50)->comment('Nombre Persona/Juridico');
            $table->string('CLIE_NOMBRE2', 50)->nullable()->comment('Segundo Nombre/Marca 1');
            $table->string('CLIE_NOMBRE3', 50)->nullable()->comment('Tercer Nombre/Marca 2');
            $table->string('CLIE_APELLIDO', 50)->comment('Apellido 1/Otro Nombre Juridico');
            $table->string('CLIE_APELLIDO2', 50)->nullable()->comment('Apellido 2/Otro Nombre Juridico');
            $table->string('CLIE_APELLIDO3', 50)->nullable()->comment('Apellido Casada/Otro Nombre Juridico');
            $table->integer('CLIE_SEXO')->default(0)->comment('Sexo: 0-No Definido 1-Masculino 2-Femenino');
            $table->string('ESTA_ID', 37)->comment('Estado Civil- Ref. Tabla Estado Civil');
            $table->string('PAIS_NAC', 37)->nullable()->comment('Pais de Nacimiento');
            $table->string('DEPA_NAC', 37)->nullable()->comment('Departamento de Nacimiento');
            $table->date('CLIE_FECHANAC')->nullable()->comment('Fecha de Nacimiento');
            $table->string('CLIE_DOCIDEN', 20)->nullable()->comment('DUI Naturales./IVA Empresas');
            $table->date('CLIE_DOCIDENVEN')->nullable()->comment('Fecha Vencimiento Documento');
            $table->string('CLIE_DOCFISCAL', 20)->nullable()->comment('NIT Cliente / NIT Empresa');
            $table->string('CLIE_PASAPORTE', 20)->nullable()->comment('Numero de Pasaporte');
            $table->string('CLIE_OTRODOC', 20)->nullable()->comment('Documento identidad apoderado');
            $table->string('CLIE_OTRODOC2', 20)->nullable()->comment('Otros documentos');
            $table->integer('CLIE_ANTECEDENTES')->default(0)->comment('Antecedentes Penales 0-No 1-Si');
            $table->string('PAIS_ID', 37)->comment('ID Pais. Ref. tabla -> pais');
            $table->string('DEPA_ID', 37)->comment('ID Departamento. Ref. Tabla -> departamento');
            $table->string('MUNI_ID', 37)->comment('ID Municipio. Ref. Tabla Municipio');
            $table->string('CLIE_DIRECCION', 100)->nullable()->comment('Direccion Cliente');
            $table->string('CLIE_TEL', 12)->nullable()->comment('Telefono Principal');
            $table->string('CLIE_TEL2', 12)->nullable()->comment('Telefono Alternativo');
            $table->string('CLIE_MAIL', 200)->nullable()->comment('Correo Contacto');
            $table->string('CLIE_MAIL2', 200)->nullable()->comment('Correo Alternativo');
            $table->integer('CLIE_TIPOCASA')->comment('Tipo Vivienda 0-Propia 1-Rentada 2-Hipotecada 3-Familiar');
            $table->string('CLIE_PROFESION', 50)->nullable()->comment('Profesion de la persona en base a DUI');
            $table->integer('CLIE_TIPOEMPLEO')->default(0)->comment('Tipo de Empleo. 0-Propio 1-Privado 2-Publico 3-Ama de Casa');
            $table->string('CLIE_TRABAJO', 30)->nullable()->comment('Nombre del Lugar de Trabajo');
            $table->string('CLIE_TRABAJODIR', 100)->nullable()->comment('Direccion del Lugar de Trabajo');
            $table->string('CLIE_TRABAJOTEL', 12)->nullable()->comment('Numero de Telefono del Trabajo');
            $table->integer('CLIE_INGRESOPROM')->default(0)->comment('Ingresos Promedios 0-Menor 300 1-minimo 2-300a500 3-500a1000 4-arribamil');
            $table->double('CLIE_INGRESOS', 8, 2)->default(0.00)->comment('Ingreso');
            $table->integer('CLIE_INGRESOADIC')->default(0)->comment('Ingresos Adicionales 0-No 1-Si');
            $table->string('CLIE_INGRESOORIGEN', 100)->nullable()->comment('Origen de los Ingresos');
            $table->string('CLIE_REF1NOMBRE', 100)->nullable()->comment('Nombre de Referencia');
            $table->string('CLIE_REF1PARENTESCO', 30)->nullable()->comment('Parentesco de Referencia');
            $table->string('CLIE_REF1DIRECCION', 200)->nullable()->comment('Direccion de Referencia');
            $table->string('CLIE_REF1TELEFONO', 12)->nullable()->comment('Numero de Telefono de Referencia');
            $table->string('CLIE_REF2NOMBRE', 100)->nullable()->comment('Nombre de Referencia');
            $table->string('CLIE_REF2PARENTESCO', 30)->nullable()->comment('Parentesco de Referencia');
            $table->string('CLIE_REF2DIRECCION', 200)->nullable()->comment('Direccion de Referencia');
            $table->string('CLIE_REF2TELEFONO', 12)->nullable()->comment('Numero de Telefono de Referencia');
            $table->string('CLIE_REF3NOMBRE', 100)->nullable()->comment('Nombre de Referencia');
            $table->string('CLIE_REF3PARENTESCO', 30)->nullable()->comment('Parentesco de Referencia');
            $table->string('CLIE_REF3DIRECCION', 200)->nullable()->comment('Direccion de Referencia');
            $table->string('CLIE_REF3TELEFONO', 12)->nullable()->comment('Numero de Telefono de Referencia');
            $table->string('CLIE_COMENTARIOS', 200)->nullable()->comment('Comentarios al Cliente');
            $table->string('CLIE_OBSERVACIONES', 200)->nullable()->comment('Observaciones Adicionales');
            $table->integer('CLIE_TIPOCLIENTE')->default(0)->comment('Tipo de Cliente. Natural -> 0 Juridico -> 1');
            $table->string('CLIE_CATEGORIA', 255)->default('')->comment('Categoria Credito: A1,A2,B1,B2,C,D,E');
            $table->integer('CLIE_SCORE')->default(0)->comment('Score Crediticio 0 a 999');
            $table->integer('CLIE_ESTADO')->comment('Estado de Cliente. 0-Bloqueado 1-Activo 2-Lista Negra');
            $table->string('SUCU_ID', 37)->comment('ID Sucursal. Ref. Tabla->sucursal');
            $table->string('EMPR_ID', 37)->comment('ID Empresa. Ref. tabla ->empresa');
            $table->string('USUA_LOGIN', 200)->nullable()->comment('Usuario que hace el cambio');
            $table->dateTime('FECHA_CAMBIO')->nullable()->comment('Fecha de cambio Registro');

            $table->unique('CLIE_ID');
            $table->index('CLIE_NOMBRE');
            $table->index('CLIE_APELLIDO');
            $table->index('CLIE_DOCIDEN');
            $table->index('CLIE_DIRECCION');
            $table->index('CLIE_TEL');
            $table->index('CLIE_ESTADO');
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('cliente');
    }
};
