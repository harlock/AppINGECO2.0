<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresCorrespondenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autores_correspondencias', function (Blueprint $table) {
            $table->id("id_autor");
            $table->string('nom_autor');
            $table->string('ap_autor');
            $table->string('am_autor');
            $table->string('correo')->unique();
            $table->string('tel');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autores_correspondencias');
    }
}

