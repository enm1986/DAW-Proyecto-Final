<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContIngresosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cont_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad')->constrained('comunidades')->onDelete('cascade');
            $table->foreignId('id_propiedad')->nullable()->constrained('propiedades');
            $table->foreignId('id_cuota')->nullable()->constrained('cont_cuotas');
            $table->string('concepto');
            $table->float('importe', 8, 2);
            $table->enum('forma_pago', ['Efectivo', 'Transferencia'])->nullable();
            $table->string('referencia')->nullable();
            $table->date('fecha_ingreso');
            $table->foreignId('id_cuenta')->constrained('cont_cuentas');
            $table->foreignId('id_fondo')->constrained('cont_fondos');
            $table->enum('tipo_ingreso', ['ordinario', 'extraordinario'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cont_gastos');
    }

}
