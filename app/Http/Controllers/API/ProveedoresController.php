<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller {

    public function index($id) {
        $propietarios = DB::table('proveedores')
                ->where([
                    ['id_comunidad', '=', $id]
                ])
                ->orderBy('nombre')
                ->get();
        return $propietarios;
    }

    public function create(Request $request, $id) {
        $proveedor = DB::table('proveedores')->insertGetId([
            'id_comunidad' => $id,
            'nombre' => $request->input('nombre'),
            'cif' => $request->input('cif'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'direccion' => $request->input('direccion'),
            'iban' => $request->input('iban'),
            'actividad' => $request->input('actividad'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Proveedor created',
                    'proveedor id' => $proveedor
        ]);
    }

    public function update(Request $request, int $id, int $proveedor) {
        $affected = DB::table('proveedores')
                ->where('id', $proveedor)
                ->update([
            'nombre' => $request->input('nombre'),
            'cif' => $request->input('cif'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'direccion' => $request->input('direccion'),
            'iban' => $request->input('iban'),
            'actividad' => $request->input('actividad'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Proveedor updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $propietario) {

        $deleted = DB::table('proveedores')
                ->where('id', $proveedor)
                ->delete();

        return response()->json([
                    'message' => 'Proveedor deleted',
                    'deleted' => $deleted
        ]);
    }

}
