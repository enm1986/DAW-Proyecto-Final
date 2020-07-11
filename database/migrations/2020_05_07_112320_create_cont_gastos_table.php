<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContGastosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cont_gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad')->constrained('comunidades')->onDelete('cascade');
            $table->foreignId('id_propietario')->nullable()->constrained('propietarios');
            $table->string('concepto');
            $table->enum('tipo_cobro', ['cuota', 'ingreso', 'alquiler']);
            $table->float('importe', 8, 2);
            $table->date('fecha_factura');
            $table->date('fecha_cobro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cont_ingresos');
    }

}
