<?php

use Illuminate\Database\Seeder;

class PropPropSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Propiedades Comunidad 1
        $this->asignarProp(1, 8, 1);
        DB::table('prop_prop')->insert([
            ['id_propiedad' => 25,
                'id_propietario' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['id_propiedad' => 26,
                'id_propietario' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]
        ]);

        //Propiedades Comunidad 2
        $this->asignarProp(11, 20, 27);
        DB::table('prop_prop')->insert([
            ['id_propiedad' => 87,
                'id_propietario' => 31,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['id_propiedad' => 88,
                'id_propietario' => 32,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['id_propiedad' => 89,
                'id_propietario' => 33,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

    /**
     * 
     * @param int $propietario_ini    ID inicial de propietarios
     * @param int $propietarios Nº de propietarios
     * @param int $propiedades_ini   ID inicial de propiedades
     * @param int $tipos_prop   Tipos de propiedades (normalmente 3: vivienda, parking, almacen)
     */
    private function asignarProp(int $propietario_ini, int $propietarios, int $propiedad_ini) {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < $propietarios; $j++) {
                DB::table('prop_prop')->insert([
                    'id_propiedad' => $propiedad_ini + $j + ($propietarios * $i),
                    'id_propietario' => $propietario_ini + $j,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

}
