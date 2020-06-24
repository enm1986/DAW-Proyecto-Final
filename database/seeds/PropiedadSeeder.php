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
            ['id_portal' => 1,
                'tipo_propiedad' => 1,
                'coeficiente' => 10,
                'descripcion' => 'Planta 1 Puerta A'],
            ['id_portal' => 1,
                'tipo_propiedad' => 3,
                'coeficiente' => 5,
                'descripcion' => 'Plaza 01'],
            ['id_portal' => 1,
                'tipo_propiedad' => 1,
                'coeficiente' => 10,
                'descripcion' => 'Planta 1 Puerta B'],
            ['id_portal' => 1,
                'tipo_propiedad' => 3,
                'coeficiente' => 7,
                'descripcion' => 'Plaza 02'],
            ['id_portal' => 2,
                'tipo_propiedad' => 1,
                'coeficiente' => 10,
                'descripcion' => 'Planta 2 Puerta A'],
            ['id_portal' => 3,
                'tipo_propiedad' => 5,
                'coeficiente' => 5,
                'descripcion' => 'Local 01'],
        ]);

        $zonacomun = ['Terraza', 'Piscina', 'Ascensor'];
        for ($i = 0; $i < 10; $i++) {
            $tipo = rand(1, 5);
            $coef = 0;
            $descripcion = null;
            switch ($tipo) {
                case 1:
                    $descripcion = 'Planta ' . rand(1, 5) . ' Puerta ' . $faker->randomLetter;
                    $coef = rand(10, 20);
                    break;
                case 2:
                    $descripcion = 'Almacen ' . rand(1, 10);
                    $coef = rand(3, 5);
                    break;
                case 3:
                    $descripcion = 'Plaza ' . rand(1, 20);
                    $coef = rand(3, 5);
                    break;
                case 4:
                    $descripcion = $zonacomun[rand(0, 2)];
                    break;
                case 5:
                    $descripcion = 'Local ' . rand(1, 3);
                    $coef = rand(1, 5);
                    break;
            }
            DB::table('propiedades')->insert(
                    ['id_portal' => rand(1, 4),
                        'tipo_propiedad' => $tipo,
                        'coeficiente' => $coef,
                        'descripcion' => $descripcion]
            );
        }
    }

}
