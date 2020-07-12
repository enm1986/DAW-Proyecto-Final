<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContCuentasController extends Controller {

    public function index($id) {

        $cuentas = DB::select('select C.id, C.banco, C.iban, C.saldo_inicial, C.fecha_saldo_ini,
            C.id_fondo, F.nombre, sum(I.importe) as ingresos, sum(G.importe) as gastos 
            from cont_cuentas C 
            left join cont_fondos F on C.id_fondo = F.id 
            left join cont_ingresos I on C.id = I.id_cuenta 
            left join cont_gastos G on C.id = G.id_cuenta 
            where C.id_comunidad = ' . $id . ' group by C.id, F.nombre order by C.banco');
        /*
          $cuentas = DB::table('cont_cuentas')
          ->join('cont_fondos', 'cont_cuentas.id_fondo', '=', 'cont_fondos.id')
          ->join('cont_ingresos', 'cont_cuentas.id', '=', 'cont_ingresos.id_cuenta')
          ->join('cont_gastos', 'cont_cuentas.id', '=', 'cont_gastos.id_cuenta')
          ->selectRaw('cont_cuentas.id, cont_cuentas.banco, cont_cuentas.iban, '
          . 'cont_cuentas.saldo_inicial, cont_cuentas.fecha_saldo_ini, '
          . 'cont_cuentas.id_fondo, cont_fondos.nombre, '
          . 'sum(cont_ingresos.importe) as ingresos, sum(cont_gastos.importe) as gastos')
          ->where('cont_cuentas.id_comunidad', '=', $id)
          ->groupByRaw('cont_fondos.nombre, cont_cuentas.id')
          ->orderBy('banco')
          ->get();
         */
        return $cuentas;
    }

    public function create(Request $request, $id) {
        $cuenta = DB::table('cont_cuentas')->insertGetId([
            'id_comunidad' => $id,
            'id_fondo' => $request->input('id_fondo'),
            'banco' => $request->input('banco'),
            'iban' => $request->input('iban'),
            'saldo_inicial' => $request->input('saldo_inicial'),
            'fecha_saldo_ini' => $request->input('fecha_saldo_ini'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('cont_ingresos')->insert([
            'id_comunidad' => $id,
            'id_cuenta' => $cuenta,
            'id_fondo' => $request->input('id_fondo'),
            'concepto' => 'Saldo inicial',
            'importe' => $request->input('saldo_inicial'),
            'fecha_ingreso' => $request->input('fecha_saldo_ini'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'cuenta created',
                    'id' => $cuenta
        ]);
    }

    public function update(Request $request, int $id, int $cuenta) {

        $anterior = DB::table('cont_cuentas')
                ->where('id', $cuenta)
                ->get();

        $saldo_post = $request->input('saldo_inicial');
        $fecha_post = $request->input('fecha_saldo_ini');

        $affected = DB::table('cont_cuentas')
                ->where('id', $cuenta)
                ->update([
            'id_fondo' => $request->input('id_fondo'),
            'banco' => $request->input('banco'),
            'iban' => $request->input('iban'),
            'saldo_inicial' => $saldo_post,
            'fecha_saldo_ini' => $fecha_post,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($anterior[0]->saldo_inicial != $saldo_post || $anterior[0]->fecha_saldo_ini != $fecha_post) {

            $ingreso = DB::table('cont_ingresos')
                    ->where('id_cuenta', $cuenta)
                    ->orderBy('created_at')
                    ->first();

            DB::table('cont_ingresos')
                    ->where('id', $ingreso->id)
                    ->update([
                        'importe' => $saldo_post,
                        'fecha_ingreso' => $fecha_post,
                        'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json([
                    'message' => 'cuenta updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $cuenta) {

        $deleted = DB::table('cont_cuentas')
                ->where('id', $cuenta)
                ->delete();

        return response()->json([
                    'message' => 'cuenta deleted',
                    'deleted' => $deleted
        ]);
    }

}
