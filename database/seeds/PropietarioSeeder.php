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
        $nif = '[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1}';

        //Usuarios que estarán en las 2 comunidades
        $usuario1 = ['id_user' => 1,
            'id_comunidad' => null,
            'nombre' => 'Admin',
            'nif' => $faker->regexify($nif),
            'email' => 'admin@com1.com',
            'telefono' => $faker->numerify($tlf),
            'iban' => $faker->iban('ES'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')];
        
        $usuario2 = ['id_user' => null,
            'id_comunidad' => null,
            'nombre' => 'Usuario',
            'nif' => $faker->regexify($nif),
            'email' => 'usuario@com1.com',
            'telefono' => $faker->numerify($tlf),
            'iban' => $faker->iban('ES'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')];



        //Propietarios comunidad 1
        $usuario1['id_comunidad'] = $usuario2['id_comunidad'] = 1;
        DB::table('propietarios')->insert([$usuario1, $usuario2]);

        for ($i = 0; $i < 8; $i++) {
            DB::table('propietarios')->insert(
                    ['id_comunidad' => 1,
                        'nombre' => $faker->name,
                        'nif' => $faker->regexify($nif),
                        'email' => $faker->unique()->safeEmail,
                        'telefono' => $faker->numerify($tlf),
                        'iban' => $faker->iban('ES'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]
            );
        }

        //Propietarios comunidad 2
        $usuario1['id_comunidad'] = $usuario2['id_comunidad'] = 2;
        DB::table('propietarios')->insert([$usuario1, $usuario2]);
        for ($i = 0; $i < 21; $i++) {
            DB::table('propietarios')->insert(
                    ['id_comunidad' => 2,
                        'nombre' => $faker->name,
                        'nif' => $faker->regexify($nif),
                        'email' => $faker->unique()->safeEmail,
                        'telefono' => $faker->numerify($tlf),
                        'iban' => $faker->iban('ES'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]
            );
        }
    }

}
