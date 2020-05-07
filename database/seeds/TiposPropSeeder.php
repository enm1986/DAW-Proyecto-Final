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
            ['id'=>1,'descripción'=>'Vivienda'],
            ['id'=>2,'descripción'=>'Almacén'],
            ['id'=>3,'descripción'=>'Aparcamiento'],
            ['id'=>4,'descripción'=>'Zona común']
        ]);
    }
}
