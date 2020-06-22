<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request, $id) {

        if ($request->session()->get('c' . $id) == 'basic') {
            return view('basic.board', ['comunidad' => $id]);
        } elseif ($request->session()->get('c' . $id) == 'admin') {
            return view('admin.board', ['comunidad' => $id]);
        } else {
            return view('welcome');
        }
    }

}
