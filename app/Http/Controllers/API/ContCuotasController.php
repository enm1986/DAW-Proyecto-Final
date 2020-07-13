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

    public function create(Request $request, $id) {

        $modo = $request->input('modo');
        $propiedades = $request->input('propiedades');
        $importe = $request->input('importe');

        switch ($modo) {
            case 'mismo':
                foreach ($propiedades as $propiedad) {
                    DB::table('cont_cuotas')->insertGetId([
                        'id_comunidad' => $id,
                        'id_propiedad' => $propiedad,
                        'concepto' => $request->input('concepto'),
                        'importe' => $importe,
                        'tipo_cuota' => $request->input('tipo_cuota'),
                        'fecha_cuota' => $request->input('fecha_cuota'),
                        'id_fondo' => $request->input('id_fondo'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                break;
            case 'coef':
                foreach ($propiedades as $propiedad) {
                    $coef = $this . getCoeficiente($propiedad);
                    DB::table('cont_cuotas')->insertGetId([
                        'id_comunidad' => $id,
                        'id_propiedad' => $propiedad,
                        'concepto' => $request->input('concepto'),
                        'importe' => number_format(($importe * $coef / 100), 2),
                        'tipo_cuota' => $request->input('tipo_cuota'),
                        'fecha_cuota' => $request->input('fecha_cuota'),
                        'id_fondo' => $request->input('id_fondo'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
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
            'id_propiedad' => $request->input('id_propiedad'),
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

}
