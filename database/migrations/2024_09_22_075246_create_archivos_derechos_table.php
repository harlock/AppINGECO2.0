<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosDerechosTable extends Migration
{
    public function up()
    {
        Schema::create('archivos_derechos', function (Blueprint $table) {
            $table->id('id_derecho');
            $table->string('archivo_derecho')->nullable();
            $table->integer('estado')->nullable();
            $table->string('mensaje')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_articulo')->nullable();

            $table->foreign('id_articulo')->references('id_articulo')->on('articulos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('archivos_derechos', function (Blueprint $table) {
            $table->dropForeign(['id_articulo']);
        });

        Schema::dropIfExists('archivos_derechos');
    }
}
