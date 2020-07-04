<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('banco', 100);
            $table->string('iban', 24);
            $table->float('saldo_inicial', 18, 2);
            $table->float('saldo_actual', 18, 2);
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
        Schema::dropIfExists('cont_cuentas');
    }
}
