<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ProfileRequest;
use Image;

class UserController extends Controller
{
    public function detail($username)
    {
        
        $user = User::where('username', $username)->first();

        return view('users.profile', compact('user'));
    }

    public function update($username, ProfileRequest $request)
    {
        $user = User::where('username', $username)->first();
        // dd($request->avatar);
        if($request->avatar){
    		$avatar = $request->avatar;
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            
            Image::make($avatar)->save( public_path('/uploads/avatars/'.$filename ) );
            
            $user->avatar = $filename;
        }
        
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->facebook_link = $request->facebook_link;

        $user->save();

        return redirect()->route('user.detail', ['username' => $user->username]);
    }
}
