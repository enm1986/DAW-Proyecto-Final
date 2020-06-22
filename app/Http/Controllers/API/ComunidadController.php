<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necesaria para usar DB
use Illuminate\Support\Facades\Auth;

class ComunidadController extends Controller {

    //
    public function index() {
        
        $comunidades = DB::table('login_acceso')
                ->join('comunidades', 'login_acceso.id_comunidad', '=', 'id')
                ->select('comunidades.id', 'comunidades.nombre',
                        'login_acceso.tipo_acceso', 'comunidades.image')
                ->where('login_acceso.id_user', '=', Auth::id())
                ->get();

        return $comunidades;
    }

    public function show($id){
        $propiedades = DB::table('propiedades')
                ->join('portales', 'propiedades.id_portal', '=', 'portales.id')
                ->join('prop_prop', 'propiedades.id', '=', 'prop_prop.id_propiedad')
                ->join('propietarios', 'prop_prop.id_propietario', '=', 'propietarios.id')
                ->join('tipos_prop', 'propiedades.tipo_propiedad', '=', 'tipos_prop.id')
                ->select('portales.direccion', 'propiedades.coeficiente',
                        'propiedades.descripcion', 'tipos_prop.tipo')
                ->where([
                    ['portales.id_comunidad', '=', $id],
                    ['propietarios.id_user', '=', Auth::id()],
                ])->get();
        return $propiedades;
    }
}
