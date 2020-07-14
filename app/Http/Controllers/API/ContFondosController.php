<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContFondosController extends Controller {

    public function index($id) {

        $fondos = DB::select('select id, nombre, descripcion, sum(ingresos) as ingresos, sum(gastos) as gastos
            from
            ((select F.id, F.nombre, F.descripcion, I.importe as ingresos, null as gastos 
                from cont_fondos F
                left outer join cont_ingresos I on F.id = I.id_fondo 
                where F.id_comunidad ='.$id.')
                union all
            (select F.id, F.nombre, F.descripcion, null as ingresos, G.importe as gastos 
                from cont_fondos F
                left outer join cont_gastos G on F.id = G.id_fondo
                where F.id_comunidad ='.$id.')) as cuentas
            group by id, nombre, descripcion');

        /*
          $fondos = DB::table('cont_fondos')
          ->where([
          ['id_comunidad', '=', $id]
          ])
          ->orderBy('nombre')
          ->get();
         */

        return $fondos;
    }

    public function create(Request $request, $id) {
        $fondo = DB::table('cont_fondos')->insertGetId([
            'id_comunidad' => $id,
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Fondo created',
                    'id' => $fondo
        ]);
    }

    public function update(Request $request, int $id, int $fondo) {
        $affected = DB::table('cont_fondos')
                ->where('id', $fondo)
                ->update([
            'id_comunidad' => $id,
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Fondo updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $fondo) {

        $deleted = DB::table('cont_fondos')
                ->where('id', $fondo)
                ->delete();

        return response()->json([
                    'message' => 'Fondo deleted',
                    'deleted' => $deleted
        ]);
    }

}
