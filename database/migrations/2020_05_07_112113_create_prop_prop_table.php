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
            $table->foreignId('id_propiedad')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('id_propietario')->constrained('propietarios')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['id_propiedad', 'id_propietario']);
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
