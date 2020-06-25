<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([
            UserSeeder::class,
            ComunidadSeeder::class,
            PortalSeeder::class,
            TiposPropSeeder::class,
            PropiedadSeeder::class,
            PropietarioSeeder::class,
            PropPropSeeder::class,
            LoginAccesoSeeder::class,
            ProveedorSeeder::class,
            ProvComunSeeder::class
        ]);
    }

}
