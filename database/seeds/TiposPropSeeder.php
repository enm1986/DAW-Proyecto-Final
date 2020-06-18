<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposPropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_prop')->insert([
            ['id'=>1,'tipo'=>'Vivienda'],
            ['id'=>2,'tipo'=>'Almacen'],
            ['id'=>3,'tipo'=>'Aparcamiento'],
            ['id'=>4,'tipo'=>'Zona comun'],
            ['id'=>5,'tipo'=>'Local']
        ]);
    }
}
