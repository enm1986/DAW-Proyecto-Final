<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            ['name'=>'usuario_com1', 'email' => 'usuario@com1.com', 'password' => Hash::make('usuario')],
            ['name'=>'admin_com1', 'email' => 'admin@com1.com', 'password' => Hash::make('admin')]
        ]);
    }

}
