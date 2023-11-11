<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('estado_civil', function (Blueprint $table) {
            $table->string('ESTA_ID', 37)->primary()->nullable(false);
            $table->string('ESTA_NOMBRE', 25)->nullable(false);
            $table->tinyInteger('ESTA_ESTADO')->nullable(false); // 1 verdadero , 0 falso
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('estado_civil');
    }
};
