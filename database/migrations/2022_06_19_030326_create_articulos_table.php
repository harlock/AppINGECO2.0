<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id("id_articulo");
            $table->string('titulo')->unique();
            $table->boolean('estado')->default(0)->nullable();
            $table->string('archivo');
            $table->string('archivo_plagio');

            $table->unsignedBigInteger('id_mesa')->nullable();
            $table->foreign('id_mesa')->references('id_mesa')->on('mesas')->onDelete('set null'); // Añadir onDelete('set null') para manejar casos de eliminación

            $table->unsignedBigInteger('id_autor')->nullable();
            $table->foreign('id_autor')->references('id_autor')->on('autores_correspondencias')->onDelete('set null'); // Añadir onDelete('set null') para manejar casos de eliminación

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
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropForeign(['id_mesa']);
            $table->dropForeign(['id_autor']);
        });

        Schema::dropIfExists('articulos');
    }
}
