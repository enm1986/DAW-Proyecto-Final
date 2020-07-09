<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropPropController extends Controller {

    public function index($id) {
        $asignaciones = DB::table('prop_prop')
                        ->join('propiedades', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                        ->select('id_propiedad', 'id_propietario')
                        ->where([
                            ['id_comunidad', '=', $id]
                        ])->get();
        return $asignaciones;
    }

    public function create(Request $request, int $id) {
        DB::table('prop_prop')->insert([
            'id_propiedad' => $request->input('id_propiedad'),
            'id_propietario' => $request->input('id_propietario'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Asignación realizada'
        ]);
    }

    public function delete(Request $request, int $id) {
        DB::table('prop_prop')
                ->where([
                    ['id_propiedad', '=', $request->input('id_propiedad')],
                    ['id_propietario', '=', $request->input('id_propietario')]
                ])
                ->delete();

        return response()->json([
                    'message' => 'Asignacion eliminada'
        ]);
    }

}
