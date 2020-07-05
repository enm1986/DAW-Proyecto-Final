<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class User extends Authenticatable implements MustVerifyEmail {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Devuelve el tipo de acceso de un usuario sobre la comunidad
     * @param int $id ID de la comunidad
     * @return string 
     */
    public function getAccess(int $id) {
        $acceso = DB::table('login_acceso')
                ->where([
                    ['id_user', '=', $this->id],
                    ['id_comunidad', '=', $id],
                ])
                ->value('tipo_acceso');
        return $acceso;
    }

    /**
     * Comprueba si un usuario es admin de una comunidad
     * Comprueba con los datos guardados en la sesión
     * @param Request $request
     * @return type
     */
    public function isAdminSession(Request $request, int $id) {
        $acceso = $request->session()->get('c' . $id);
        return $acceso == 'admin';
    }

}
