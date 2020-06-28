<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necesaria para usar DB
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

}
