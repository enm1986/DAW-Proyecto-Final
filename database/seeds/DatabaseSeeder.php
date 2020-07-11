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
            LoginAccesoSeeder::class,
            TiposPropSeeder::class,
            PropiedadSeeder::class,
            PropietarioSeeder::class,
            PropPropSeeder::class,
            ProveedorSeeder::class,
            //ContCuentas::class,
            //ContPresupuestos::class,
            //ContPagosSeeder::class,
            //ContCobrosSeeder::class
        ]);
    }
    
    public static function random_float($min, $max) {
        return round(($min + lcg_value() * (abs($max - $min))), 2);
    }

}
