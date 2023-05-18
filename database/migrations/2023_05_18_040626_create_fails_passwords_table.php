<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailsPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fails_passwords', function (Blueprint $table) {
            $table->id();
            $table->integer("intentos");
            $table->dateTime("fecha_ultimo_intento")->nullable();
            $table->dateTime("fecha_bloqueo")->nullable();
            $table->integer("id_usuario");
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
        Schema::dropIfExists('fails_passwords');
    }
}
