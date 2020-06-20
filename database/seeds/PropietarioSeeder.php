<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
//use Faker\Generator as Faker;

class PropietarioSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create('es_ES');
        $tlf = '### ## ## ##';
        $nif = '[0-9]{8}[A-Z]{1}';
        DB::table('propietarios')->insert([
            ['id_user' => 1,
                'nombre' => 'UsuarioCom1',
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'nif' => $faker->regexify($nif),
                'email' => 'usuario@com1.com',
                'telefono' => $faker->numerify('### ## ## ##'),
                'iban' => $faker->iban('ES')],
            ['id_user' => 2,
                'nombre' => 'AdminCom1',
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'nif' => $faker->regexify($nif),
                'email' => 'admin@com1.com',
                'telefono' => $faker->numerify($tlf),
                'iban' => $faker->iban('ES')],
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('propietarios')->insert(
                    ['nombre' => $faker->firstName,
                        'apellido1' => $faker->lastName,
                        'apellido2' => $faker->lastName,
                        'nif' => $faker->regexify($nif),
                        'email' => $faker->unique()->safeEmail,
                        'telefono' => $faker->numerify($tlf),
                        'iban' => $faker->iban('ES')]
            );
        }
    }

}
