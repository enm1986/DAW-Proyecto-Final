<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContPresupuestosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cont_presupuestos', function (Blueprint $table) {
            $table->foreignId('id_comunidad')->constrained('comunidades');
            $table->year('year');
            $table->float('presupuesto', 8, 2);
            $table->timestamps();
            $table->primary(['id_comunidad', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cont_presupuestos');
    }

}
