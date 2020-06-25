<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProvComunSeeder extends Seeder {
               
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($comunidad = 1; $comunidad <= 2; $comunidad++) {
            for ($proveedor = 1; $proveedor <= 8; $proveedor++) {
                DB::table('prov_comun')->insert([
                    ['id_comunidad' => $comunidad, 'id_proveedor' => $proveedor],
                ]);
            }
        }
    }

}
