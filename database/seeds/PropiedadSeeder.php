<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class PropiedadSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {
        DB::table('propiedades')->insert([
                ['id' => 1,
                    'id_portal' => 1,
                    'tipo_propiedad' => 1,
                    'coeficiente' => 10,
                    'descripcion' => 'Planta 1 Puerta A'],
                ['id' => 2,
                    'id_portal' => 1,
                    'tipo_propiedad' => 1,
                    'coeficiente' => 10,
                    'descripcion' => 'Planta 1 Puerta B']
        ]);

        for ($i = 3; $i < 10; $i++) {
            DB::table('propiedades')->insert(
                    ['id' => $i,
                        'id_portal' => rand(1, 5),
                        'tipo_propiedad' => rand(1, 5),
                        'coeficiente' => rand(5, 60),
                        'descripcion' => 'Planta '. rand(1, 5) .' Puerta ' . $faker->randomLetter],
            );
        }
    }

}
