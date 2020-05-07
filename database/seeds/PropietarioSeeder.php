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
            ['nombre' => 'UsuarioCom1', 'apellido1' => $faker->lastName, 'apellido2' => $faker->lastName, 'nif' => $faker->numerify('12345678A'), 'email' => 'usuario@com1.com', 'telefono' => $faker->randomNumber(9)],
            ['nombre' => 'AdminCom1', 'apellido1' => $faker->lastName, 'apellido2' => $faker->lastName, 'nif' => $faker->numerify('12345678A'), 'email' => 'admin@com1.com', 'telefono' => $faker->randomNumber(9)],
            ['nombre' => $faker->firstName(), 'apellido1' => $faker->lastName, 'apellido2' => $faker->lastName, 'nif' => $faker->numerify('12345678A'), 'email' => $faker->unique()->safeEmail, 'telefono' => $faker->randomNumber(9)],
            ['nombre' => $faker->firstName(), 'apellido1' => $faker->lastName, 'apellido2' => $faker->lastName, 'nif' => $faker->numerify('12345678A'), 'email' => $faker->unique()->safeEmail, 'telefono' => $faker->randomNumber(9)]
        ]);
    }
}
