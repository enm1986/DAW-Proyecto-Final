<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ContCuentasSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {

        for ($comunidad = 1; $comunidad <= 2; $comunidad++) {
            $fondo_ini = 1+(3*($comunidad-1));
            for ($fondo = $fondo_ini; $fondo <= $fondo_ini+1; $fondo++) {
                DB::table('cont_cuentas')->insert([
                    'id_comunidad' => $comunidad,
                    'id_fondo' => $fondo,
                    'banco' => 'Banco Proyecto',
                    'iban' => $faker->iban('ES'),
                    'saldo_inicial' => 1000,
                    'fecha_saldo_ini' => date('Y-m-d'),
                    'saldo_actual' => 1000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

}
