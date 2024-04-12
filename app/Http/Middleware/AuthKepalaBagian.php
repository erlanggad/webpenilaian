<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKepalaBagian
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
        if($request->session()->get('user')['role'] == 'Kepala Bagian'){
            return $next($request);
          }
          return redirect('login')->with('failed','Akses ditolak ! Anda bukan Kepala Bagian.');
    }
}
