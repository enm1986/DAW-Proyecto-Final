<?php

use Illuminate\Database\Seeder;

class LoginAccesoSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('login_acceso')->insert([
            ['id_comunidad' => 1,
                'id_user' => 1,
                'tipo_acceso' => 'basic'],
            ['id_comunidad' => 1,
                'id_user' => 2,
                'tipo_acceso' => 'admin'],
            ['id_comunidad' => 3,
                'id_user' => 2,
                'tipo_acceso' => 'basic']
        ]);
    }

}
