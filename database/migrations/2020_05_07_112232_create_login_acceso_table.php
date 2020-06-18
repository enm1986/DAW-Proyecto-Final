<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_acceso', function (Blueprint $table) {
            $table->foreignId('id_comunidad')->constrained('comunidades');
            $table->foreignId('id_user')->constrained('users');
            $table->enum('tipo_acceso',['admin', 'basic']);
            $table->timestamps();
            $table->primary(['id_comunidad', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_acceso');
    }
}
