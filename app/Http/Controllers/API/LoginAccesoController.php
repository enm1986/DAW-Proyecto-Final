<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginAccesoController extends Controller {

    public function create(Request $request) {
        $id_comunidad = $this->getComunidad($request->input('cif'));
        $mensaje = 'No existe la comunidad';
        if ($id_comunidad) {
            $email = Auth::user()->email;
            $id_propietario = $this->getPropietario($id_comunidad, $email);
            if ($id_propietario) {
                $this->createAcceso($id_comunidad, $id_propietario);
                $mensaje = 'Autorizado';
            } else {
                $mensaje = 'No Autorizado';
            }
        }

        return response()->json([
                    'message' => $mensaje
        ]);
    }

    private function getComunidad(string $cif) {
        $id = DB::table('comunidades')
                ->where('cif', '=', $cif)
                ->value('id');
        return $id;
    }

    private function getPropietario(int $id_comunidad, string $email) {
        $id = DB::table('propietarios')
                ->where([
                    ['id_comunidad', '=', $id_comunidad],
                    ['email', '=', $email]
                ])
                ->value('id');
        return $id;
    }

    private function createAcceso(int $id_comunidad, int $id_propietario) {
        DB::table('login_acceso')->insert([
            'id_user' => Auth::id(),
            'id_comunidad' => $id_comunidad,
            'tipo_acceso' => 'basic',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('propietarios')
                ->where('id', $id_propietario)
                ->update([
                    'id_user' => Auth::id()
        ]);
    }

}
