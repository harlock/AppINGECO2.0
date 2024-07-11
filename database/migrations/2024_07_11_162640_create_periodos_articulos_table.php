<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosArticulosTable extends Migration
{
    public function up()
    {
        Schema::create('periodos_articulos', function (Blueprint $table) {
            $table->id('id_periodo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodos_articulos');
    }
}
