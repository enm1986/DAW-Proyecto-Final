<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont_anticipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_comunidad')->nullable()->constrained('comunidades');
            $table->foreignId('id_propietario')->nullable()->constrained('propietarios');
            $table->float('importe', 8, 2);
            $table->date('fecha_anticipo');
            $table->foreignId('id_cuenta')->nullable()->constrained('cont_cuentas');
            $table->foreignId('id_fondo')->constrained('cont_fondos');
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
        Schema::dropIfExists('cont_anticipos');
    }
}
