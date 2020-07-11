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
            $table->string('concepto');
            $table->date('fecha_factura');
            $table->float('importe', 8, 2);
            $table->foreignId('id_forma_pago')->constrained('cont_formas_pago');
            $table->string('Referencia');
            $table->foreignId('id_cuenta')->nullable()->constrained('cont_cuentas');
            $table->enum('tipo_gasto', ['ordinario', 'extraordinario']);
            $table->foreignId('id_fondo')->constrained('cont_fondos');
            $table->foreignId('id_propietario')->nullable()->constrained('propietarios');
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
