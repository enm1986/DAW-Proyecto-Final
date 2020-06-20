<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necesaria para usar DB
use Illuminate\Support\Facades\Auth;

class ComunidadController extends Controller {

    //
    public function index() {
        
        $comunidades = DB::table('login_acceso')
                ->join('comunidades', 'login_acceso.id_comunidad', '=', 'comunidades.id')
                ->select('login_acceso.id_user', 'login_acceso.tipo_acceso', 'comunidades.nombre', 'comunidades.image')
                ->where('login_acceso.id_user', '=', Auth::id())
                ->get();

        return $comunidades;
    }

}
