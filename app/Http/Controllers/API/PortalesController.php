<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortalesController extends Controller {

    public function index($id) {
        $portales = DB::table('portales')
                ->select()
                ->where('portales.id_comunidad', '=', $id)
                ->get();
        return $portales;
    }

    public function create(Request $request) {
        $portal = DB::table('portales')->insertGetId([
            'id_comunidad' => $request->input('id_comunidad'),
            'direccion' => $request->input('direccion'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Portal created',
                    'insert portal id' => $portal
        ]);
    }

    public function update(Request $request, int $id) {

        $affected = DB::table('portales')
                ->where('id', $id)
                ->update([
            'direccion' => $request->input('direccion'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
                    'message' => 'Portal updated',
                    'affected' => $affected
        ]);
    }

    public function delete(int $id) {

        $deleted = DB::table('portales')
                ->where('id', $id)
                ->delete();

        return response()->json([
                    'message' => 'Portal deleted',
                    'deleted' => $deleted
        ]);
    }

}
