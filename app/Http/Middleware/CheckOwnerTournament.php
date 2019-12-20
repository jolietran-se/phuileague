<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Tournament;
use Session;

class CheckOwnerTournament
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
        $tournament = Tournament::where('slug', $request->slug)->first();
        
        if($userID == $tournament->owner_id){
            return $next($request);
        }else{
            Session::flash('check_owner', 'Bạn không phải người tổ chức giải đấu này');
            
            return redirect()->route('tournament.listregister', $tournament->slug);
        }
    }
}
