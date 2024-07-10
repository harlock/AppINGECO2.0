<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_pagos', function (Blueprint $table) {
            $table->id('id_comprobante');
            $table->string('comprobante');
            $table->string('referencia');
            $table->tinyInteger('factura')->default(2);
            $table->string('constancia_fiscal')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');

            $table->unsignedBigInteger('id_articulo')->nullable();
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');

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
        Schema::dropIfExists('comprobantes_pagos');
    }
}
