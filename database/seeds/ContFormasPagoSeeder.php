<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContFormasPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cont_formas_pago')->insert([
            ['forma_pago' => 'Efectivo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['forma_pago' => 'Transferencia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }
}
