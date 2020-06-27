<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ContPagosSeeder extends Seeder {
    /*
      'Prov-Administracion',
      'Prov-Seguros',
      'Prov-Limpieza',
      'Prov-Reformas',
      'Prov-Piscina',
      'Prov-Agua',
      'Prov-Electr',
      'Prov-Mantenimiento'
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {

        //Comunidad 1
        $fecha1 = new DateTime();
        $fecha2 = new DateTime();

        //Facturas Anuales
        DB::table('cont_pagos')->insert([
            ['id_comunidad' => 1,
                'id_proveedor' => 2,
                'concepto' => 'Seguro Resp. Civil',
                'tipo_pago' => 'fijo',
                'importe' => 300,
                'fecha_factura' => $fecha1->setDate(2020, 3, 9),
                'fecha_pago' => $fecha2->setDate(2020, 3, 11)],
            ['id_comunidad' => 1,
                'id_proveedor' => 4,
                'concepto' => 'Reforma Fachada',
                'tipo_pago' => 'variable',
                'importe' => 2500,
                'fecha_factura' => $fecha1->setDate(2020, 6, 28),
                'fecha_pago' => null]
        ]);

        $this->pagos_fijo(1, 7, 'Electricidad', 50, 70);
        $this->pagos_fijo(1, 3, 'Limpieza', 50, 70);
        $this->pagos_fijo(1, 6, 'Agua', 30, 50, 2);
    }

    /**
     * Genera Pagos fijos cada cierto número de meses desde inicio de año hasta la fecha actual
     * @param int $comunidad id
     * @param int $proveedor id
     * @param string $concepto 
     * @param int $importe_min 
     * @param int $importe_max
     * @param int $periodo  (cada número de meses)
     */
    private function pagos_fijo(int $comunidad, int $proveedor, string $concepto,
            int $importe_min, int $importe_max, int $periodo = 1) {
        $fecha1 = new DateTime();
        $fecha2 = new DateTime();
        for ($i = $periodo; $i <= date('m'); $i += $periodo) {
            DB::table('cont_pagos')->insert([
                'id_comunidad' => $comunidad,
                'id_proveedor' => $proveedor, // Agua
                'concepto' => 'Factura ' . $concepto,
                'tipo_pago' => 'fijo',
                'importe' => DatabaseSeeder::random_float($importe_min, $importe_max),
                'fecha_factura' => $fecha1->setDate(2020, $i, 15),
                'fecha_pago' => $fecha2->setDate(2020, $i, 17)
            ]);
        }
    }

}
