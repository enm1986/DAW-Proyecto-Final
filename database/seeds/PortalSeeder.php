<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('portales')->insert([
            ['id' => 1, 'id_comunidad' => 1, 'direccion' => 'Calle Comunidad 1'],
            ['id' => 2, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2A'],
            ['id' => 3, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2B'],
            ['id' => 4, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2C'],
            ['id' => 5, 'id_comunidad' => 3, 'direccion' => 'Calle Comunidad 3']
        ]);
    }

}
