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

    public function admin(int $id) {
        return view('admin.board', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }

    public function datos(int $id) {
        return view('admin.datos', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }

    public function propiedades(int $id) {
        return view('admin.propiedades', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }

    public function propietarios(int $id) {
        return view('admin.propietarios', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }

    public function asignar(int $id) {
        return view('admin.asignar', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }

    public function proveedores(int $id) {
        return view('admin.proveedores', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }
    
    public function cuentas(int $id) {
        return view('admin.cuentas', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }
    
    public function gastos(int $id) {
        return view('admin.gastos', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }
    
    public function ingresos(int $id) {
        return view('admin.ingresos', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }
    
    public function cuotas(int $id) {
        return view('admin.cuotas', ['comunidad' => $this->getComunidad($id), 'acceso' => 'admin']);
    }
    
    private function getComunidad($id) {
        $comunidad = DB::table('comunidades')
                ->where('id', '=', $id)
                ->get();
        return $comunidad[0];
    }

}
