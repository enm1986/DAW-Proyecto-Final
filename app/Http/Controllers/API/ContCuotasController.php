<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContCuotasController extends Controller {

    public function index($id) {
        $cuotas = DB::table('cont_cuotas')
                ->join('cont_fondos', 'cont_cuotas.id_fondo', '=', 'cont_fondos.id')
                ->join('propiedades', 'cont_cuotas.id_propiedad', '=', 'propiedades.id', 'left outer')
                ->select('cont_cuotas.id', 'cont_cuotas.concepto', 'cont_cuotas.fecha_cuota',
                        'cont_cuotas.importe', 'cont_cuotas.tipo_cuota',
                        'cont_cuotas.id_fondo', 'cont_fondos.nombre as fondo',
                        'cont_cuotas.id_propiedad', 'propiedades.descripcion as propiedad')
                ->where([
                    ['cont_cuotas.id_comunidad', '=', $id]
                ])
                ->orderByDesc('cont_cuotas.fecha_cuota')
                ->get();
        return $cuotas;
    }

    public function indexPropietario($id) {
        $cuotas = DB::table('cont_cuotas')
                ->join('prop_prop', 'cont_cuotas.id_propiedad', '=', 'prop_prop.id_propiedad', 'left outer')
                ->join('propietarios', 'prop_prop.id_propietario', '=', 'propietarios.id', 'left outer')
                ->select('cont_cuotas.id', 'cont_cuotas.concepto', 'cont_cuotas.fecha_cuota',
                        'cont_cuotas.importe', 'cont_cuotas.tipo_cuota', 'cont_cuotas.id_propiedad')
                ->where([
                    ['cont_cuotas.id_comunidad', '=', $id],
                    ['propietarios.id_user', '=', Auth::id()]
                ])
                ->orderByDesc('cont_cuotas.fecha_cuota')
                ->get();
        return $cuotas;
    }

    public function create(Request $request, $id) {
        $modo = $request->input('modo');
        $propiedades = $request->input('propiedades');
        $importe = $request->input('importe');

        $concepto = $request->input('concepto');
        $tipo_cuota = $request->input('tipo_cuota');
        $fecha_cuota = $request->input('fecha_cuota');
        $fondo = $request->input('id_fondo');

        switch ($modo) {
            case 'mismo':
                $importe_parte = number_format(($importe / count($propiedades)), 2);
                foreach ($propiedades as $propiedad) {
                    $this->insertCuota($id, $propiedad, $concepto, $importe_parte, $tipo_cuota, $fecha_cuota, $fondo);
                }
                break;
            case 'coef':
                $parte_prop = $this->getParteProp($propiedades);
                foreach ($propiedades as $propiedad) {
                    $coef = $this->getCoeficiente($propiedad) * $parte_prop;
                    $imp_prop = number_format(($importe * $coef), 2);
                    $this->insertCuota($id, $propiedad, $concepto, $imp_prop, $tipo_cuota, $fecha_cuota, $fondo);
                }
                break;
        }

        return response()->json([
                    'message' => 'cuota created',
        ]);
    }

    public function update(Request $request, int $id, int $cuota) {
        $affected = DB::table('cont_cuotas')
                ->where('id', $cuota)
                ->update([
            'concepto' => $request->input('concepto'),
            'importe' => $request->input('importe'),
            'tipo_cuota' => $request->input('tipo_cuota'),
            'fecha_cuota' => $request->input('fecha_cuota'),
            'id_fondo' => $request->input('id_fondo'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'cuota updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $cuota) {
        $deleted = DB::table('cont_cuotas')
                ->where('id', $cuota)
                ->delete();

        return response()->json([
                    'message' => 'cuota deleted',
                    'deleted' => $deleted
        ]);
    }

    private function getCoeficiente(int $id_comunidad) {
        $coef = DB::table('propiedades')
                ->where('id', $id_comunidad)
                ->value('coeficiente');

        return $coef;
    }

    private function getParteProp($propiedades) {
        $coef_parcial = 0;
        foreach ($propiedades as $propiedad) {
            $coef_parcial += $this->getCoeficiente($propiedad);
        }
        return (1 / $coef_parcial);
    }

    private function insertCuota($comunidad, $propiedad, $concepto, $importe, $tipo, $fecha, $fondo) {
        DB::table('cont_cuotas')->insert([
            'id_comunidad' => $comunidad,
            'id_propiedad' => $propiedad,
            'concepto' => $concepto,
            'importe' => $importe,
            'tipo_cuota' => $tipo,
            'fecha_cuota' => $fecha,
            'id_fondo' => $fondo,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

}
