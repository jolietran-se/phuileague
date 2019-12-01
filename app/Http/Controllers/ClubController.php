<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClubRequest;
use Illuminate\Support\Str;
use App\Club;
use App\User;
use Image;
use Log;
use Auth;
use Session;

class ClubController extends Controller
{
    public function index(){
        return view('clubs.list');
    }
    public function create(){
        return view('clubs.create');
    }

    public function store(ClubRequest $request){
        // dd($request->all());
        $club = new Club();
        $club->name = $request->name;
        $club->owner_id = $request->owner_id;
        $club->logo = $request->logo;
        $club->gender = $request->gender;
        $club->ages = $request->ages;
        $club->phone = $request->phone;
        $club->email = $request->email;
        $club->club_type = $request->club_type;
        $club->description = $request->description;
        $club->slug = Str::slug($request->name,'-');

        $club->save();
        
        $user = User::where('id', $club->owner_id)->first();

        Session::flash('create_club', 'Tạo đội bóng thành công!');

        return redirect()->route('user.clubs', $user->username);
    }

    public function logoCrop(Request $request){
        $logo_file = $request->logo;
        list($type, $logo_file) = explode(';', $logo_file);
        list(, $logo_file) = explode(',', $logo_file);
        $logo_file = base64_decode($logo_file);
        
        $logo_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/club-logos/'.$logo_name);
        file_put_contents($path, $logo_file);

        return response()->json(['status'=>true, 'logo_name'=>$logo_name]);
    }
    
    public function uniformCrop(Request $request){
        $uniform_file = $request->uniform;

        list($type, $uniform_file) = explode(';', $uniform_file);
        list(, $uniform_file) = explode(',', $uniform_file);
        $uniform_file = base64_decode($uniform_file);
        
        $uniform_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/club-uniforms/'.$uniform_name);
        file_put_contents($path, $uniform_file);

        return response()->json(['status'=>true, 'uniform_name'=>$uniform_name]);
    }
}
