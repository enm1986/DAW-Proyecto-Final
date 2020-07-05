<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Redirecciona al usuario dependiendo del acceso que tenga sobre una comunidad
     * @param Request $request
     * @return view
     */
    public function index(int $id) {
        $acceso = Auth::user()->getAccess($id);
        if (!empty($acceso)) {
            return view('board', ['comunidad' => $this->getComunidad($id), 'acceso' => $acceso]);
        } else {
            return view('welcome');
        }
    }

/**
 * Redirecciona al usuario dependiendo de si es Admin de la comunidad
 * @param int $id ID de la comunidad
 * @return type
 */
    public function admin(int $id) {
        $acceso = Auth::user()->getAccess($id);
        if ($acceso == 'admin') {
            return view('admin.board', ['comunidad' => $this->getComunidad($id), 'acceso' => $acceso]);
        } else {
            return view('welcome');
        }
    }

    private function getComunidad($id) {
        $comunidad = DB::table('comunidades')
                ->where('id', '=', $id)
                ->get();
        return $comunidad[0];
    }

}
