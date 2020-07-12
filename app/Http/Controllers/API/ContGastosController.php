<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContGastosController extends Controller {

    public function index($id) {
        $gastos = DB::table('cont_gastos')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderByDesc('fecha_factura')
                ->get();
        return $gastos;
    }

    public function create(Request $request, $id) {
        $gasto = DB::table('cont_gastos')->insertGetId([
            'id_comunidad' => $id,
            'id_proveedor' => $request->input('id_proveedor'),
            'concepto' => $request->input('concepto'),
            'fecha_factura' => $request->input('fecha_factura'),
            'importe' => $request->input('importe'),
            'referencia' => $request->input('referencia'),
            'tipo_gasto' => $request->input('tipo_gasto'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'id_propietario' => $request->input('id_propietario'),
            'fecha_pago' => $request->input('fecha_pago'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'gasto created',
                    'id' => $gasto
        ]);
    }

    public function update(Request $request, int $id, int $gasto) {
        $affected = DB::table('cont_gastos')
                ->where('id', $gasto)
                ->update([
            'id_proveedor' => $request->input('id_proveedor'),
            'concepto' => $request->input('concepto'),
            'fecha_factura' => $request->input('fecha_factura'),
            'importe' => $request->input('importe'),
            'referencia' => $request->input('referencia'),
            'tipo_gasto' => $request->input('tipo_gasto'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'id_propietario' => $request->input('id_propietario'),
            'fecha_pago' => $request->input('fecha_pago'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'gasto updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $gasto) {
        $deleted = DB::table('cont_gastos')
                ->where('id', $gasto)
                ->delete();

        return response()->json([
                    'message' => 'gasto deleted',
                    'deleted' => $deleted
        ]);
    }

}
