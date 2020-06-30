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
            ['id' => 1, 'id_comunidad' => 1, 'direccion' => 'Calle Comunidad 1',
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2A',
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 3, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2B',
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 4, 'id_comunidad' => 2, 'direccion' => 'Calle Comunidad 2C',
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ]);
    }

}
