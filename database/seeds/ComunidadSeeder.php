<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComunidadSeeder extends Seeder {

    /**
     * Crea 2 comunidades
     *
     * @return void
     */
    public function run() {
        DB::table('comunidades')->insert([
            ['nombre' => 'Comunidad 1',
                'cif' => 'H11111111',
                'direccion' => 'Calle Com1 Nº 111',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            ['nombre' => 'Comunidad 2',
                'cif' => 'H22222222',
                'direccion' => 'Calle Com2 Nº 222',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

}
