<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropPropTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_prop', function (Blueprint $table) {
            $table->foreignId('id_propiedad');
            $table->foreignId('id_propietario');
            $table->decimal('coef_propietario', 5, 2);
            $table->timestamps();
            $table->primary(['id_propiedad', 'id_propietario']);
            $table->foreign('id_propiedad')->references('id')->on('propiedades');
            $table->foreign('id_propietario')->references('id')->on('propietarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prop_prop');
    }
}
