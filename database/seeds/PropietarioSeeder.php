<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class PropietarioSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {
        DB::table('propietarios')->insert([
            ['id_user' => 1,
                'nombre' => 'UsuarioCom1',
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'nif' => $faker->randomNumber(8).$faker->randomLetter,
                'email' => 'usuario@com1.com',
                'telefono' => $faker->randomNumber(9),
                'iban' => $faker->randomNumber()],
            ['id_user' => 2,
                'nombre' => 'AdminCom1',
                'apellido1' => $faker->lastName,
                'apellido2' => $faker->lastName,
                'nif' => $faker->randomNumber(8).$faker->randomLetter,
                'email' => 'admin@com1.com',
                'telefono' => $faker->randomNumber(9),
                'iban' => $faker->randomNumber()],
        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('propietarios')->insert(
                    ['nombre' => $faker->firstName(),
                        'apellido1' => $faker->lastName,
                        'apellido2' => $faker->lastName,
                        'nif' => $faker->randomNumber(8).$faker->randomLetter,
                        'email' => $faker->unique()->safeEmail,
                        'telefono' => $faker->randomNumber(9),
                        'iban' => $faker->randomNumber()]
            );
        }
    }

}
