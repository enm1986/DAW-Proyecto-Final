<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContCuentasController extends Controller {

    public function index($id) {
        $cuentas = DB::table('cont_cuentas')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderBy('banco')
                ->get();
        return $cuentas;
    }

    public function create(Request $request, $id) {
        $cuenta = DB::table('cont_cuentas')->insertGetId([
            'id_comunidad' => $id,
            'id_fondo' => $request->input('id_fondo'),
            'banco' => $request->input('banco'),
            'iban' => $request->input('iban'),
            'saldo_inicial' => $request->input('saldo_inicial'),
            'fecha_saldo_ini' => $request->input('fecha'),
            'saldo_actual' => $request->input('saldo_inicial'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('cont_ingresos')->insert([
            'id_comunidad' => $id,
            'id_cuenta' => $cuenta,
            'id_fondo' => $request->input('id_fondo'),
            'concepto' => 'Saldo inicial',
            'importe' => $request->input('importe'),
            'fecha_ingreso' => $request->input('fecha'),
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
        $fecha_post = $request->input('fecha');

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

        if ($anterior->saldo_inicial != $saldo_post || $anterior->fecha_saldo_ini != $fecha_post) {

            $id_ingreso = DB::table('cont_ingresos')
                            ->where('id_cuenta', $cuenta)
                            ->orderBy('created_at')
                            ->first()->value('id');

            DB::table('cont_ingresos')
                    ->where('id', $id_ingreso)
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
