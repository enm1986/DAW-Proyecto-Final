<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContCobrosSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Comunidad 1
        $this->cobros_cuota(1, 1);
    }

    private function cobros_cuota(int $comunidad, int $periodo = 1) {

        $propietarios = $this->get_propietarios_coef($comunidad);
        $presupuesto = $this->get_presupuesto($comunidad);

        foreach ($propietarios as $propietario) {
            $coef = $propietario->coef;
            $importe = round((($presupuesto * $coef / 100) / (12 / $periodo)), 2);

            $fecha1 = new DateTime();
            $fecha2 = new DateTime();

            for ($i = 1; $i <= date('m'); $i += $periodo) {
                DB::table('cont_cobros')->insert([
                    'id_comunidad' => $comunidad,
                    'id_propietario' => $propietario->id,
                    'concepto' => 'Cuota mes ' . $i,
                    'tipo_cobro' => 'cuota',
                    'importe' => $importe,
                    'fecha_factura' => $fecha1->setDate(2020, $i, 2),
                    'fecha_cobro' => $fecha2->setDate(2020, $i, 3),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    /**
     * Obtiene el presupuesto del año en curso de una comunidad
     * @param int $comunidad
     */
    private function get_presupuesto(int $comunidad) {
        $presupuesto = DB::table('cont_presupuestos')
                        ->select('presupuesto')
                        ->where([
                            ['id_comunidad', '=', $comunidad],
                            ['year', '=', date('Y')],
                        ])->get();
        return $presupuesto[0]->presupuesto;
    }

    /**
     * Devuelve una lista de propietarios que pertenencen a una comunidad 
     * con su coeficiente de participación
     * @param int $comunidad id
     * @return type [{id, coef}]
     */
    private function get_propietarios_coef(int $comunidad) {
        $propietarios = DB::table('portales')
                ->join('propiedades', 'portales.id', '=', 'propiedades.id_portal')
                ->join('prop_prop', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                ->select('prop_prop.id_propietario as id', DB::raw('SUM(coeficiente) as coef'))
                ->where('portales.id_comunidad', '=', $comunidad)
                ->groupBy('prop_prop.id_propietario')
                ->get();
        return $propietarios;
    }

}
