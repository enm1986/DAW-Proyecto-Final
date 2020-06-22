<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request, $id) {
        
        if ($request->session()->get('c'.$id) == 'basic') {
            return view('basic.profile');
        } elseif ($request->session()->get('c'.$id) == 'admin') {
            return view('admin.profile');
        } else {
            return view('welcome');
        }
    }

}
