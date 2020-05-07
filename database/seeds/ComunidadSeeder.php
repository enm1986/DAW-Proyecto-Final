<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComunidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comunidades')->insert([
            ['id'=>1,'nombre_comunidad'=>'Comunidad 1', 'cif' => 'H11111111'],
            ['id'=>2,'nombre_comunidad'=>'Comunidad 2', 'cif' => 'H22222222'],
            ['id'=>3,'nombre_comunidad'=>'Comunidad 3', 'cif' => 'H33333333']
        ]);
    }
}
