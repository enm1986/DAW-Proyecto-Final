<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContCuentasController extends Controller {

    public function index($id) {

        $cuentas = DB::select('select id, banco, iban, saldo_inicial, fecha_saldo_ini, id_fondo, nombre,
            sum(ingresos) as ingresos, sum(gastos) as gastos
            from
            ((select C.id, C.banco, C.iban, C.saldo_inicial, C.fecha_saldo_ini,
                C.id_fondo, F.nombre, I.concepto, I.importe as ingresos, null as gastos 
                from cont_cuentas C 
                left outer join cont_fondos F on C.id_fondo = F.id 
                left outer join cont_ingresos I on C.id = I.id_cuenta 
                where C.id_comunidad ='.$id.')
                union all
            (select C.id, C.banco, C.iban, C.saldo_inicial, C.fecha_saldo_ini,
                C.id_fondo, F.nombre, G.concepto, null as ingresos, G.importe as gastos 
                from cont_cuentas C 
                left outer join cont_fondos F on C.id_fondo = F.id 
                left outer join cont_gastos G on C.id = G.id_cuenta 
                where C.id_comunidad ='.$id.')) as cuentas
            group by id, banco, iban, saldo_inicial, fecha_saldo_ini, id_fondo, nombre');

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
