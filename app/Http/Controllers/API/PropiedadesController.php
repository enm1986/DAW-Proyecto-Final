<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PropiedadesController extends Controller {

    /**
     * Devuelve las propiedades del usuario en una comunidad
     * @param type $id ID de una comunidad
     * @return type [{direccion, coeficiente, descripcion, tipo}, ...]
     */
    public function index($id) {
        $propiedades = DB::table('propiedades')
                        ->join('portales', 'propiedades.id_portal', '=', 'portales.id')
                        ->join('prop_prop', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                        ->join('propietarios', 'prop_prop.id_propietario', '=', 'propietarios.id')
                        ->join('tipos_prop', 'propiedades.id_tipo', '=', 'tipos_prop.id')
                        ->select('portales.direccion', 'propiedades.coeficiente',
                                'propiedades.descripcion', 'tipos_prop.tipo')
                        ->where([
                            ['portales.id_comunidad', '=', $id],
                            ['propietarios.id_user', '=', Auth::id()],
                        ])->get();
        return $propiedades;
    }

    public function tipos() {
        return DB::table('tipos_prop')->get();
    }

    public function indexAdmin($id) {
        $propiedades = DB::table('propiedades')
                        ->join('portales', 'propiedades.id_portal', '=', 'portales.id')
                        ->join('prop_prop', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                        ->select('propiedades.id',
                                'portales.direccion',
                                'propiedades.id_tipo',
                                'propiedades.descripcion',
                                'propiedades.coeficiente'
                        )
                        ->where([
                            ['portales.id_comunidad', '=', $id]
                        ])->get();
        return $propiedades;
    }

    public function create(Request $request) {
        $propiedad = DB::table('propiedades')->insertGetId([
            'id_portal' => $request->input('id_portal'),
            'id_tipo' => $request->input('id_tipo'),
            'coeficiente' => $request->input('coeficiente'),
            'descripcion' => $request->input('descripcion'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Propiedad created',
                    'insert propiedad id' => $propiedad
        ]);
    }

    public function update(Request $request, int $id) {

        $affected = DB::table('comunidades')
                ->where('id', $id)
                ->update([
            'coeficiente' => $request->input('coeficiente'),
            'descripcion' => $request->input('descripcion'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Propiedad updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id) {

        $deleted = DB::table('propiedades')
                ->where('id', $id)
                ->delete();

        return response()->json([
                    'message' => 'Propiedad deleted',
                    'deleted' => $deleted
        ]);
    }

}
