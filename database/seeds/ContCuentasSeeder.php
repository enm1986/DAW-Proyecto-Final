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
            $fondo_ini = 1 + (3 * ($comunidad - 1));
            for ($fondo = $fondo_ini; $fondo <= $fondo_ini + 1; $fondo++) {
                $cuenta = DB::table('cont_cuentas')->insertGetId([
                    'id_comunidad' => $comunidad,
                    'id_fondo' => $fondo,
                    'banco' => 'Banco ' . $fondo,
                    'iban' => $faker->iban('ES'),
                    'saldo_inicial' => 1000,
                    'fecha_saldo_ini' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                DB::table('cont_ingresos')->insert([
                    'id_comunidad' => $comunidad,
                    'id_cuenta' => $cuenta,
                    'id_fondo' => $fondo,
                    'concepto' => 'Saldo inicial',
                    'importe' => 1000,
                    'fecha_ingreso' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

}
