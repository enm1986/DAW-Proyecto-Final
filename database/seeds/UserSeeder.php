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
            ['name' => 'admin_com1',
                'email' => 'admin@com1.com',
                'password' => Hash::make('admin'),
                'api_token' => Str::random(60),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'usuario_com1',
                'email' => 'usuario@com1.com',
                'password' => Hash::make('usuario'),
                'api_token' => Str::random(60),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }

}
