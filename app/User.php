<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class User extends Authenticatable implements MustVerifyEmail
{
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
     * Comprueba si el usuario tiene acceso a una comunidad
     * @param Request $request
     * @return boolean
     */
    public function hasAccess(Request $request){
        $acceso = $request->session()->get('c' . $request->input('cid'));
        return !empty($acceso);
    }
    
    /**
     * Comprueba si un usuario es admin de una comunidad
     * Comprueba con la BD
     * @param int $comunidad
     * @return boolean
     */
    public function isAdminDB(int $comunidad){
        $acceso = DB::table('login_acceso')
                ->select('tipo_acceso')
                ->where([
                            ['id_user', '=', $this->id],
                            ['id_comunidad', '=', $comunidad],
                        ])
                ->get();
        return $acceso[0]->tipo_acceso == 'admin';
    }
    
    /**
     * Comprueba si un usuario es admin de una comunidad
     * Comprueba con los datos guardados en la sesión
     * @param Request $request
     * @return type
     */
    public function isAdminSession(Request $request){
        $acceso = $request->session()->get('c' . $request->input('cid'));
        return $acceso == 'admin';
    }
}
