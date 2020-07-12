<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContIngresosController extends Controller {

    public function index($id) {
        $ingresos = DB::table('cont_ingresos')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderByDesc('fecha_factura')
                ->get();
        return $ingresos;
    }

    public function create(Request $request, $id) {
        $ingreso = DB::table('cont_ingresos')->insertGetId([
            'id_comunidad' => $id,
            'id_propietario' => $request->input('id_propietario'),
            'id_propiedad' => $request->input('id_propiedad'),
            'id_cuota' => $request->input('id_cuota'),
            'concepto' => $request->input('concepto'),
            'importe' => $request->input('importe'),
            'forma_pago' => $request->input('forma_pago'),
            'referencia' => $request->input('referencia'),
            'tipo_ingreso' => $request->input('tipo_ingreso'),
            'fecha_ingreso' => $request->input('fecha_ingreso'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'ingreso created',
                    'id' => $ingreso
        ]);
    }

    public function update(Request $request, int $id, int $ingreso) {
        $affected = DB::table('cont_ingresos')
                ->where('id', $ingreso)
                ->update([
            'id_propietario' => $request->input('id_propietario'),
            'id_propiedad' => $request->input('id_propiedad'),
            'id_cuota' => $request->input('id_cuota'),
            'concepto' => $request->input('concepto'),
            'importe' => $request->input('importe'),
            'forma_pago' => $request->input('forma_pago'),
            'referencia' => $request->input('referencia'),
            'tipo_ingreso' => $request->input('tipo_ingreso'),
            'fecha_ingreso' => $request->input('fecha_ingreso'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'ingreso updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $ingreso) {
        $deleted = DB::table('cont_ingresos')
                ->where('id', $ingreso)
                ->delete();

        return response()->json([
                    'message' => 'ingreso deleted',
                    'deleted' => $deleted
        ]);
    }

}
