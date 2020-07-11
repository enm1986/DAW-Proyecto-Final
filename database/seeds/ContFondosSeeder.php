<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContFondosSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $fondos = ['Fondo Ordinario', 'Fondo Extraordinario', 'Fondo Reserva'];

        for ($comunidad = 1; $comunidad <= 2; $comunidad++) {
            foreach ($fondos as $fondo) {
                DB::table('cont_fondos')->insert([
                    'id_comunidad' => $comunidad,
                    'nombre' => $fondo,
                    'descripcion' => $fondo,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

}
