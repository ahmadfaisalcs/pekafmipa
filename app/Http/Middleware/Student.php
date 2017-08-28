<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Redirect;

class Student
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
      if (Session::has('adm_name')) {
        return redirect()->back();
      }
      elseif (Session::has('ktu_name')) {
        return redirect()->back();
      }
      elseif (Session::has('srt_name')) {
        return redirect()->back();
      }
      elseif (!Session::has('nim') && !Session::has('adm_name') && !Session::has('ktu_name') && !Session::has('srt_name')) {
        return Redirect::to('/');
      }

      return $next($request);
    }
}
