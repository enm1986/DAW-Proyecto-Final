<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContCuotasController extends Controller {

    public function index($id) {
        $cuotas = DB::table('cont_cuotas')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderByDesc('fecha_cuota')
                ->get();
        return $cuotas;
    }

    public function create(Request $request, $id) {
        $cuota = DB::table('cont_cuotas')->insertGetId([
            'id_comunidad' => $id,
            'id_propietario' => $request->input('id_propietario'),
            'id_propiedad' => $request->input('id_propiedad'),
            'concepto' => $request->input('concepto'),
            'importe' => $request->input('importe'),
            'tipo_cuota' => $request->input('tipo_cuota'),
            'fecha_cuota' => $request->input('fecha_cuota'),
            'id_fondo' => $request->input('id_fondo'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'cuota created',
                    'id' => $cuota
        ]);
    }

    public function update(Request $request, int $id, int $cuota) {
        $affected = DB::table('cont_cuotas')
                ->where('id', $cuota)
                ->update([
            'id_propietario' => $request->input('id_propietario'),
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

}
