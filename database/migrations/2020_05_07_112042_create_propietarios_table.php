<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users');
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2');
            $table->string('nif', 9)->unique();
            $table->string('telefono', 9);
            $table->string('email');
            $table->string('iban', 24)->unique();
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
        Schema::dropIfExists('propietarios');
    }
}
