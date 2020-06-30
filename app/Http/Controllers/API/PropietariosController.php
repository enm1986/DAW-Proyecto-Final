<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropietariosController extends Controller {

    public function index($id) {
        $propietarios = DB::table('propietarios')
                        ->join('prop_prop', 'prop_prop.id_propietario', '=', 'propietarios.id')
                        ->join('propiedades', 'propiedades.id', '=', 'prop_prop.id_propiedades')
                        ->join('portales', 'portales.id', '=', 'propiedades.id_portal')
                        ->select('propietarios.*')
                        ->where([
                            ['portales.id_comunidad', '=', $id]
                        ])->distinct()->get();
        return $propietarios;
    }

    public function create(Request $request) {
        $propietario = DB::table('propietarios')->insertGetId([
            'nombre' => $request->input('nombre'),
            'apellido1' => $request->input('apellido1'),
            'apellido2' => $request->input('apellido2'),
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

    public function update(Request $request, int $id) {

        $affected = DB::table('propietarios')
                ->where('id', $id)
                ->update([
            'nombre' => $request->input('nombre'),
            'apellido1' => $request->input('apellido1'),
            'apellido2' => $request->input('apellido2'),
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

    //Revisar
    public function delete(int $id) {

        $deleted = DB::table('propietarios')
                ->where('id', $id)
                ->delete();

        return response()->json([
                    'message' => 'Propietario deleted',
                    'deleted' => $deleted
        ]);
    }

}
