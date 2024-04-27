<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {

        if(Auth::guard("employee")->guest()){
            if($request->ajax() || $request->wantsJson()){
                return response('Unauthorized',401);
            }else{
                return redirect()->route('rupayapay.login');
            }
        }

        $response = $next($request);

    // return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
    //             ->header('Pragma','no-cache')
    //             ->header('Expires','Sat, 26 Jul 1997 05:00:00 GMT');

    // Set headers for BinaryFileResponse
    $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

    return $response;

        // return $response;
    }
}
