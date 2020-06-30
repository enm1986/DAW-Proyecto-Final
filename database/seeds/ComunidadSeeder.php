<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComunidadSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('comunidades')->insert([
            ['id' => 1, 'nombre' => 'Comunidad 1', 'cif' => 'H11111111', 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'nombre' => 'Comunidad 2', 'cif' => 'H22222222', 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

}
