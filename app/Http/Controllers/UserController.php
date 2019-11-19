<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ProfileRequest;
use Image;
use Log;
use Alert;
use Session;

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

        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->facebook_link = $request->facebook_link;

        $user->save();

        if($user){
            Session::flash('update-account', 'Cập nhật thành công!');
        }

        return redirect()->route('user.detail', ['username' => $user->username]);
    }

    public function imageCrop(Request $request)
    {   
		// Log::info('start ');

        $image_file = $request->image;
        list($type, $image_file) = explode(';', $image_file);
        list(, $image_file)      = explode(',', $image_file);
        $image_file = base64_decode($image_file);
        $image_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/avatars/'.$image_name);
        file_put_contents($path, $image_file);

        $user = User::where('username', $request->username)->first();
        $user->avatar = $image_name;
        $user->save();

		// Log::info('end ');
        if($image_name){
            Session::flash('update-avatar', 'Cập nhật thành công!');
        }

        return response()->json(['status'=>true]);
    }

}
