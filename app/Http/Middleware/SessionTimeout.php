<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;


class SessionTimeout
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
        
       
        if(Auth::guard()->user()){

            $user = Auth::guard()->user();
 
            $now = Carbon::now();
        
            $last_seen = Carbon::parse($user->last_seen_at);
        
            $absence = $now->diffInMinutes($last_seen);
            
            if($request->ajax())
            {
                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return response()->json(['message' => 'Session expired'], 403);
                }
            }else{

                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return redirect("/session-timeout");
                }

            }

        
            $user->last_seen_at = $now->format('Y-m-d H:i:s');
            $user->save();
        }elseif(Auth::guard("employee")->user()){

            $employee = Auth::guard("employee")->user();
         
            $now = Carbon::now();
        
            $last_seen = Carbon::parse($employee->last_seen_at);
        
            $absence = $now->diffInMinutes($last_seen);
            
            if($request->ajax())
            {
                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return response()->json(['message' => 'Session expired'], 403);
                }
            }else{

                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return redirect("/flakpay/session-timeout");
                }

            }
        
            $employee->last_seen_at = $now->format('Y-m-d H:i:s');
            $employee->save();
        }elseif(Auth::guard("merchantemp")->user()){

            $employee = Auth::guard("merchantemp")->user();
               
            $now = Carbon::now();
        
            $last_seen = Carbon::parse($employee->last_seen_at);
        
            $absence = $now->diffInMinutes($last_seen);
            
            if($request->ajax())
            {
                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return response()->json(['message' => 'Session expired'], 403);
                }
            }else{

                // If user has been inactivity longer than the allowed inactivity period
                if ($absence > config('session.custlifetime')) {
                    session(["nextpage"=>$request->path()]);
                    return redirect("/session-timeout");
                }

            }
        
            $employee->last_seen_at = $now->format('Y-m-d H:i:s');
            $employee->save();
        }else{
            return redirect('/flakpay/login');
        }
        

        return $next($request);
    }
}
