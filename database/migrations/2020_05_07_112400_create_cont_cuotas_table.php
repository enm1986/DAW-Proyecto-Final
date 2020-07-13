<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContCuotasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cont_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad')->constrained('comunidades')->onDelete('cascade');
            $table->foreignId('id_propiedad')->constrained('propiedades');
            $table->string('concepto');
            $table->date('fecha_cuota');
            $table->float('importe', 8, 2);
            $table->foreignId('id_fondo')->constrained('cont_fondos');
            $table->enum('tipo_cuota', ['ordinario', 'extraordinario']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cont_cuotas');
    }

}
