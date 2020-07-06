<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $comunidad = $request->route('id');
        $acceso = Auth::user()->getAccess($comunidad);
        
        if ($acceso != 'admin') {
            return redirect('home');
        }
        
        return $next($request);
    }
}
