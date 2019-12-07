<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Club;
use Session;

class CheckOwnerCLub
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
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        $club = Club::where('slug', $request->slug)->first();

        if($userID == $club->owner_id){
            return $next($request);
        }else{
            Session::flash('check_owner', 'Bạn không phải người đại diện đội bóng này');

            return redirect()->route('club.profile', $club->slug);
        }
    }
}
