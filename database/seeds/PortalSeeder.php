<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portales')->insert([
            ['id_comunidad'=>1,'direccion'=>'Calle Comunidad 1'],
            ['id_comunidad'=>2,'direccion'=>'Calle Comunidad 2A'],
            ['id_comunidad'=>2,'direccion'=>'Calle Comunidad 2B'],
            ['id_comunidad'=>2,'direccion'=>'Calle Comunidad 2C'],
            ['id_comunidad'=>3,'direccion'=>'Calle Comunidad 3']
        ]);
    }
}
