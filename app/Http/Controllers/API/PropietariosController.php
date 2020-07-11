<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropietariosController extends Controller {

    public function index($id) {
        $propietarios = DB::table('propietarios')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderBy('nombre')
                ->get();
        return $propietarios;
    }

    public function create(Request $request, $id) {
        $propietario = DB::table('propietarios')->insertGetId([
            'id_comunidad' => $id,
            'nombre' => $request->input('nombre'),
            'nif' => $request->input('nif'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'iban' => $request->input('iban'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Propiedad created',
                    'insert propietario id' => $propietario
        ]);
    }

    public function update(Request $request, int $id, int $propietario) {

        $affected = DB::table('propietarios')
                ->where('id', $propietario)
                ->update([
            'nombre' => $request->input('nombre'),
            'nif' => $request->input('nif'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'iban' => $request->input('iban'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Propitario updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $propietario) {

        $deleted = DB::table('propietarios')
                ->where('id', $propietario)
                ->delete();

        return response()->json([
                    'message' => 'Propietario deleted',
                    'deleted' => $deleted
        ]);
    }

}
