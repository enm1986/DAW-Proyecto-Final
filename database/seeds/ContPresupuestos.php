<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContPresupuestos extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('cont_presupuestos')->insert([
            'id_comunidad' => 1,
            'year' => date('Y'),
            'presupuesto' => 5000
        ]);
    }

}
