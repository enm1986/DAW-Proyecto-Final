<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad');
            $table->string('direccion', 100);
            $table->timestamps();
            $table->foreign('id_comunidad')->references('id')->on('comunidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portales');
    }
}