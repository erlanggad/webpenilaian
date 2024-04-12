<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKaryawan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->get('user')['role'] == 'karyawan'){
            return $next($request);
          }
          return redirect('login')->with('failed','Akses ditolak ! Anda bukan Karyawan.');
    }
}
