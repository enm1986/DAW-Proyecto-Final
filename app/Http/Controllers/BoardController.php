<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Redirecciona al usuario dependiendo del acceso que tenga sobre una comunidad
     * @param Request $request
     * @return view
     */
    public function index(Request $request) {
        $parametros = ['comunidad_id' => $request->input('cid'),
            'comunidad_nombre' => $request->input('nombre')];

        if (Auth::user()->hasAccess($request)) {
            return view('board', $parametros);
        } else {
            return view('welcome');
        }
    }
    
    /**
     * Redirecciona al usuario dependiendo de si es Admin de la comunidad
     * @param Request $request
     * @return view
     */
    public function admin(Request $request) {
        $parametros = ['comunidad_id' => $request->input('cid')];

        if (Auth::user()->isAdminSession($request)) {
            return view('admin.home', $parametros);
        } else {
            return view('welcome');
        }
    }

}
