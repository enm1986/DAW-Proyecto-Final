<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropiedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_portal');
            $table->foreignId('tipo_propiedad');
            $table->decimal('coeficiente', 5, 2);
            $table->timestamps();
            $table->foreign('id_portal')->references('id')->on('portales');
            $table->foreign('tipo_propiedad')->references('id')->on('tipos_prop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propiedades');
    }
}
