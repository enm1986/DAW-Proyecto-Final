<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ProveedorSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {
        $tlf = '### ## ## ##';
        $cif = '[ABCDEFJ]{1}[0-9]{8}';
        $proveedores = ['Prov-Administracion', 'Prov-Seguros', 'Prov-Limpieza',
            'Prov-Reformas', 'Prov-Piscina', 'Prov-Agua', 'Prov-Electr', 'Prov-Mantenimiento'];

        foreach ($proveedores as $nombre) {
            $data = ['id_comunidad' => null,
                'nombre' => $nombre,
                'cif' => $faker->unique()->regexify($cif),
                'email' => $faker->unique()->safeEmail,
                'telefono' => $faker->numerify($tlf),
                'iban' => $faker->iban('ES'),
                'descripcion' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')];
            for ($comunidad = 1; $comunidad <= 2; $comunidad++) {
                $data['id_comunidad'] = $comunidad;
                $data['descripcion'] = $faker->text(100);
                DB::table('proveedores')->insert($data);
            }
        }
    }

}
