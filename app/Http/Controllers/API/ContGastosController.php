<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContGastosController extends Controller {

    public function index($id) {
        $gastos = DB::table('cont_gastos')
                ->join('proveedores', 'cont_gastos.id_proveedor', '=', 'proveedores.id', 'left outer')
                ->join('cont_cuentas', 'cont_gastos.id_cuenta', '=', 'cont_cuentas.id')
                ->join('cont_fondos', 'cont_gastos.id_fondo', '=', 'cont_fondos.id')
                ->join('propiedades', 'cont_gastos.id_propiedad', '=', 'propiedades.id', 'left outer')
                ->select('cont_gastos.id', 'cont_gastos.id_proveedor', 'proveedores.nombre as proveedor',
                        'cont_gastos.concepto', 'cont_gastos.fecha_factura', 'cont_gastos.importe',
                        'cont_gastos.forma_pago', 'cont_gastos.referencia', 'cont_gastos.tipo_gasto',
                        'cont_gastos.id_cuenta', 'cont_cuentas.banco', 'cont_gastos.id_fondo', 'cont_fondos.nombre as fondo',
                        'cont_gastos.id_propiedad', 'propiedades.descripcion as propiedad', 'cont_gastos.fecha_pago')
                ->where([
                    ['cont_gastos.id_comunidad', '=', $id]
                ])
                ->orderByDesc('cont_gastos.fecha_factura')
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
            'forma_pago' => $request->input('forma_pago'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'id_propiedad' => $request->input('id_propiedad'),
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
            'forma_pago' => $request->input('forma_pago'),
            'id_cuenta' => $request->input('id_cuenta'),
            'id_fondo' => $request->input('id_fondo'),
            'id_propiedad' => $request->input('id_propiedad'),
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
