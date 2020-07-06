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
    public function indexUser($id) {
        $propiedades = DB::table('propiedades')
                        ->join('prop_prop', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                        ->join('propietarios', 'prop_prop.id_propietario', '=', 'propietarios.id')
                        ->join('tipos_prop', 'propiedades.id_tipo', '=', 'tipos_prop.id')
                        ->select('tipos_prop.tipo', 'propiedades.descripcion', 'propiedades.coeficiente')
                        ->where([
                            ['propiedades.id_comunidad', '=', $id],
                            ['propietarios.id_user', '=', Auth::id()],
                        ])->get();
        return $propiedades;
    }

    public function tipos() {
        return DB::table('tipos_prop')->get();
    }

    public function indexAll($id) {
        $propiedades = DB::table('propiedades')
                ->join('tipos_prop', 'propiedades.id_tipo', '=', 'tipos_prop.id')
                ->select('propiedades.id',
                        'propiedades.id_tipo',
                        'tipos_prop.tipo',
                        'propiedades.descripcion',
                        'propiedades.coeficiente'
                )
                ->where([
                    ['propiedades.id_comunidad', '=', $id]
                ])
                ->orderBy('propiedades.id_tipo')
                ->orderBy('propiedades.descripcion')
                ->get();
        return $propiedades;
    }

    public function create(Request $request) {
        $propiedad = DB::table('propiedades')->insertGetId([
            'id_comunidad' => $request->input('id_comunidad'),
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

    public function update(Request $request, int $id, int $propiedad) {

        $affected = DB::table('propiedades')
                ->where('id', $propiedad)
                ->update([
            'id_tipo' => $request->input('tipo'),
            'coeficiente' => $request->input('coeficiente'),
            'descripcion' => $request->input('descripcion'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Propiedad updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id, int $propiedad) {

        $deleted = DB::table('propiedades')
                ->where('id', $propiedad)
                ->delete();

        return response()->json([
                    'message' => 'Propiedad deleted',
                    'deleted' => $deleted
        ]);
    }

}
