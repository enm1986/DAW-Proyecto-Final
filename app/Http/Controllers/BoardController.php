<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $acceso = $request->session()->get('c' . $request->input('cid'));
        $parametros = ['comunidad_id' => $request->input('cid'),
            'comunidad_nombre' => $request->input('nombre')];

        if ($acceso == 'basic') {
            return view('basic.board', $parametros);
        } elseif ($acceso == 'admin') {
            return view('admin.board', $parametros);
        } else {
            return view('welcome');
        }
    }

}
