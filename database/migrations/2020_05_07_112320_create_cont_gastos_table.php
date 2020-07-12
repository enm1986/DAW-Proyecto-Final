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
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores');
            $table->string('concepto')->nullable();
            $table->date('fecha_factura');
            $table->float('importe', 8, 2);
            $table->enum('forma_pago', ['Efectivo', 'Transferencia']);
            $table->string('referencia')->nullable();
            $table->foreignId('id_cuenta')->nullable()->constrained('cont_cuentas');
            $table->enum('tipo_gasto', ['ordinario', 'extraordinario']);
            $table->foreignId('id_fondo')->constrained('cont_fondos');
            $table->foreignId('id_propiedad')->nullable()->constrained('propiedades');
            $table->date('fecha_pago')->nullable();
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
