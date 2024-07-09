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
    
            $table->unsignedBigInteger('id_mesa')->nullable();
            $table->foreign('id_mesa')->references('id_mesa')->on('mesas');
    
            $table->unsignedBigInteger('id_autor')->nullable();
            $table->foreign('id_autor')->references('id_autor')->on('autores_correspondencias');
    
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
        Schema::dropIfExists('articulos');
    }
    
}
