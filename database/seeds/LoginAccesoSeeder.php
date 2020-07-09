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
                'tipo_acceso' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['id_comunidad' => 2,
                'id_user' => 1,
                'tipo_acceso' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

}
