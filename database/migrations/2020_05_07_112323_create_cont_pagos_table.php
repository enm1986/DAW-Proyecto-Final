<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad')->constrained('comunidades');
            $table->string('concepto');
            $table->enum('tipo_pago',['fijo', 'variable']);
            $table->float('importe', 8, 2);
            $table->date('fecha_factura');
            $table->foreignId('id_proveedor')->constrained('proveedores');
            $table->boolean('pagado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cont_gastos');
    }
}
