<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ComunidadesController extends Controller {

    /**
     * Devuelve las comunidades a la que el usuario tiene acceso
     * @return type
     */
    public function index() {
        $comunidades = DB::table('login_acceso')
                ->join('comunidades', 'login_acceso.id_comunidad', '=', 'id')
                ->select('comunidades.id', 'comunidades.nombre',
                        'login_acceso.tipo_acceso', 'comunidades.image')
                ->where('login_acceso.id_user', '=', Auth::id())
                ->get();

        return $comunidades;
    }

    public function show(int $id) {
        $comunidad = DB::table('comunidades')
                ->where('id', '=', $id)
                ->get();

        return $comunidad;
    }

    /**
     * Crea una comunidad y asigna al usuario como admin
     * @param Request $request
     * @return type
     */
    public function create(Request $request) {
        $comunidad = DB::table('comunidades')->insertGetId([
            'nombre' => $request->input('nombre'),
            'cif' => $request->input('cif'),
            'iban' => $request->input('iban'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $acceso = DB::table('login_acceso')->insert([
            'id_comunidad' => $comunidad,
            'id_user' => Auth::id(),
            'tipo_acceso' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Comunidad created',
                    'insert comunidad' => $comunidad,
                    'insert acceso' => $acceso
        ]);
    }

    public function update(Request $request, int $id) {
        
        $affected = DB::table('comunidades')
                ->where('id', $id)
                ->update([
            'nombre' => $request->input('nombre'),
            'cif' => $request->input('cif'),
            'iban' => $request->input('iban'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Comunidad updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id) {

        $deleted = DB::table('comunidades')
                ->where('id', $id)
                ->delete();

        return response()->json([
                    'message' => 'Comunidad deleted',
                    'deleted' => $deleted
        ]);
    }

}
