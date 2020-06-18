<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunProvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comun_prov', function (Blueprint $table) {
            $table->foreignId('id_comunidad')->constrained('comunidades');
            $table->foreignId('id_proveedor')->constrained('proveedores');
            $table->timestamps();
            $table->primary(['id_comunidad', 'id_proveedor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comun_prov');
    }
}
