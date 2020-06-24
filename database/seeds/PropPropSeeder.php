<?php

use Illuminate\Database\Seeder;

class PropPropSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('prop_prop')->insert([
            ['id_propiedad' => 1,
                'id_propietario' => 1,
                'coef_propietario' => 100],
            ['id_propiedad' => 2,
                'id_propietario' => 1,
                'coef_propietario' => 100],
            ['id_propiedad' => 3,
                'id_propietario' => 2,
                'coef_propietario' => 100],
            ['id_propiedad' => 4,
                'id_propietario' => 2,
                'coef_propietario' => 100],
            ['id_propiedad' => 5,
                'id_propietario' => 2,
                'coef_propietario' => 100],
            ['id_propiedad' => 6,
                'id_propietario' => 2,
                'coef_propietario' => 50]
        ]);
    }

}
