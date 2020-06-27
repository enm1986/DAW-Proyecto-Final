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
        $propiedades = [1, 9, 17];
        foreach ($propiedades as $propiedad) {
            for ($i = 0; $i < 8; $i++) {
                DB::table('prop_prop')->insert([
                    'id_propiedad' => $propiedad + $i,
                    'id_propietario' => $i + 1,
                    'coef_propietario' => 100
                ]);
            }
        }

        for ($i = 25; $i <= 26; $i++) {
            DB::table('prop_prop')->insert([
                'id_propiedad' => $i,
                'id_propietario' => rand(3, 60),
                'coef_propietario' => 100
            ]);
        }

        //Propiedades Comunidad 2
        DB::table('prop_prop')->insert([
            'id_propiedad' => 27,
            'id_propietario' => 1,
            'coef_propietario' => 100
        ]);
        DB::table('prop_prop')->insert([
            'id_propiedad' => 215,
            'id_propietario' => 2,
            'coef_propietario' => 100
        ]);
        for ($i = 28; $i <= 214; $i++) {
            DB::table('prop_prop')->insert([
                'id_propiedad' => $i,
                'id_propietario' => rand(3, 60),
                'coef_propietario' => 100
            ]);
        }
    }

}
