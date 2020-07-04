<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropiedadSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Propiedades Comunidad 1
        $this->add_viviendas(1, 60, 4, ['Izq', 'Der']);
        $this->add_almacenes(1, 10, 8);
        $this->add_aparcamientos(1, 20, 8);
        $this->add_locales(1, 10, ['A', 'B']);

        //Propiedades Comunidad 2
        $this->add_viviendas(2, 60, 5, ['A', 'B', 'C', 'D']);
        $this->add_almacenes(2, 10, 20);
        $this->add_aparcamientos(2, 20, 20);
        $this->add_locales(2, 10, ['A', 'B', 'C']);
    }

    /**
     * 
     * @param int $comunidad    Id de la comunidad
     * @param float $coeficiente Coef total de las viviendas sobre la comunidad
     * @param int $plantas      Nº de plantas
     * @param array $puertas    Puertas de cada planta ej: ['izq', 'der']
     */
    private function add_viviendas(int $comunidad, float $coeficiente, int $plantas, array $puertas) {
        $coef = $coeficiente / ($plantas * count($puertas));
        for ($planta = 1; $planta <= $plantas; $planta++) {
            foreach ($puertas as $puerta) {
                DB::table('propiedades')->insert([
                    'id_comunidad' => $comunidad,
                    'id_tipo' => 1,
                    'coeficiente' => $coef,
                    'descripcion' => 'Planta ' . $planta . ' Puerta ' . $puerta,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    /**
     * 
     * @param int $comunidad    Id de la comunidad
     * @param float $coeficiente Coef total sobre la comunidad
     * @param int $almacenes    Nº de almacenes
     */
    private function add_almacenes(int $comunidad, float $coeficiente, int $almacenes) {
        $coef = $coeficiente / $almacenes;
        for ($almacen = 1; $almacen <= $almacenes; $almacen++) {
            DB::table('propiedades')->insert([
                'id_comunidad' => $comunidad,
                'id_tipo' => 2,
                'coeficiente' => $coef,
                'descripcion' => 'Almacen ' . $almacen,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * 
     * @param int $comunidad    Id de la comunidad
     * @param float $coeficiente Coef total sobre la comunidad
     * @param int $plazas   Nº total de plazas de aparcamiento
     */
    private function add_aparcamientos(int $comunidad, float $coeficiente, int $plazas) {
        $coef = $coeficiente / $plazas;
        for ($plaza = 1; $plaza <= $plazas; $plaza++) {
            DB::table('propiedades')->insert([
                'id_comunidad' => $comunidad,
                'id_tipo' => 3,
                'coeficiente' => $coef,
                'descripcion' => 'Plaza ' . $plaza,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * 
     * @param int $comunidad    Id de la comunidad
     * @param float $coeficiente Coef total sobre la comunidad
     * @param array $locales    Locales del portal ej. (['A', 'B', 'C'])
     */
    private function add_locales(int $comunidad, float $coeficiente, array $locales) {
        $coef = $coeficiente / count($locales);
        foreach ($locales as $local) {
            DB::table('propiedades')->insert([
                'id_comunidad' => $comunidad,
                'id_tipo' => 4,
                'coeficiente' => $coef,
                'descripcion' => 'Local ' . $local,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

}
