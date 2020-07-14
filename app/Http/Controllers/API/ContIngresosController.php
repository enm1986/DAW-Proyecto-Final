<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContIngresosController extends Controller {

    public function index($id) {
        $ingresos = DB::table('cont_ingresos')
                ->join('cont_cuentas', 'cont_ingresos.id_cuenta', '=', 'cont_cuentas.id')
                ->join('cont_fondos', 'cont_ingresos.id_fondo', '=', 'cont_fondos.id')
                ->join('propiedades', 'cont_ingresos.id_propiedad', '=', 'propiedades.id', 'left outer')
                ->select('cont_ingresos.id', 'cont_ingresos.concepto', 'cont_ingresos.fecha_ingreso',
                        'cont_ingresos.importe', 'cont_ingresos.forma_pago',
                        'cont_ingresos.referencia', 'cont_ingresos.tipo_ingreso',
                        'cont_ingresos.id_cuenta', 'cont_cuentas.banco',
                        'cont_ingresos.id_fondo', 'cont_fondos.nombre as fondo',
                        'cont_ingresos.id_propiedad', 'propiedades.descripcion as propiedad')
                ->where([
                    ['cont_ingresos.id_comunidad', '=', $id]
                ])
                ->orderByDesc('fecha_ingreso')
                ->get();
        return $ingresos;
    }
    
    public function indexPropietario($id) {
        $ingresos = DB::table('cont_ingresos')
                ->join('prop_prop', 'cont_ingresos.id_propiedad', '=', 'prop_prop.id_propiedad', 'left outer')
                ->join('propietarios', 'prop_prop.id_propietario', '=', 'propietarios.id', 'left outer')
                ->select('cont_ingresos.id', 'cont_ingresos.concepto', 'cont_ingresos.fecha_ingreso',
                        'cont_ingresos.importe', 'cont_ingresos.referencia', 'cont_ingresos.tipo_ingreso',
                        'cont_ingresos.id_propiedad')
                ->where([
                    ['cont_ingresos.id_comunidad', '=', $id],
                    ['propietarios.id_user', '=', Auth::id()]
                ])
                ->orderByDesc('fecha_ingreso')
                ->get();
        return $ingresos;
    }

    public function create(Request $request, $id) {
        $ingreso = DB::table('cont_ingresos')->insertGetId([
            'id_comunidad' => $id,
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
