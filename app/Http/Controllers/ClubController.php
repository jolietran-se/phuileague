<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClubRequest;
use App\Http\Requests\PlayerRequest;
use Illuminate\Support\Str;
use App\Club;
use App\User;
use App\Player;
use App\Option;
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

    public function store(ClubRequest $request)
    {
        // dd($request->all());
        $club = new Club();
        $club->name = $request->name;
        $club->owner_id = $request->owner_id;
        $club->logo = $request->logo;
        $club->uniform = $request->uniform;
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

    public function logoCrop(Request $request)
    {
        $logo_file = $request->logo;
        list($type, $logo_file) = explode(';', $logo_file);
        list(, $logo_file) = explode(',', $logo_file);
        $logo_file = base64_decode($logo_file);
        
        $logo_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/club-logos/'.$logo_name);
        file_put_contents($path, $logo_file);

        return response()->json(['status'=>true, 'logo_name'=>$logo_name]);
    }
    
    public function uniformCrop(Request $request)
    {
        $uniform_file = $request->uniform;

        list($type, $uniform_file) = explode(';', $uniform_file);
        list(, $uniform_file) = explode(',', $uniform_file);
        $uniform_file = base64_decode($uniform_file);
        
        $uniform_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/club-uniforms/'.$uniform_name);
        file_put_contents($path, $uniform_file);

        return response()->json(['status'=>true, 'uniform_name'=>$uniform_name]);
    }
    public function avatarCrop(Request $request)
    {
        $file = $request->avatar;

        list($type, $file) = explode(';', $file);
        list(, $file) = explode(',', $file);
        $file = base64_decode($file);
        
        $file_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/player-avatars/'.$file_name);
        file_put_contents($path, $file);

        return response()->json(['status'=>true, 'file_name'=>$file_name]);
    }

    public function profile($slug)
    {
        $club = Club::where('slug', $slug)->first();

        return view('clubs.profile', compact('club'));
    }

    // Danh sách thành viên
    public function member($slug)
    {
        $club = Club::where('slug', $slug)->first();

        $players = Player::where('club_id', $club->id)->get();
        
        $club->number_player = count($players);

        $club->save();

        return view('clubs.member', compact('club', 'players'));
    }
    // Thêm thành viên
    public function addMember(PlayerRequest $request, $slug)
    {
        // dd($request->all());

        $club = Club::where('slug', $slug)->first();

        $player = new Player();
        $player->name = $request->name;
        $player->club_id = $request->club_id;
        $player->uniform_number = $request->uniform_number;
        $player->uniform_name = $request->uniform_name;
        $player->position = $request->position;
        $player->role = $request->role;
        $player->ismain = $request->ismain;
        $player->phone = $request->phone;
        $player->birthday = $request->birthday; 

        if(isset($request->avatar )) $player->avatar = $request->avatar ;
        if(isset($request->front_idcard )) $player->front_idcard = $request->front_idcard ;
        if(isset($request->backside_idcard )) $player->backside_idcard = $request->backside_idcard ;

        $player->save();

        Session::flash('create_player', "Thêm cầu thủ thành công");

        return redirect()->route('club.member', $club->slug);
        
    }

    public function editMember(Request $request, $slug)
    {   
        Log::info('start: '.$request->player_id);
        $player_id = $request->player_id;

        $player = Player::where('id', $player_id)->first();
        $player->name = $request->name;
        $player->uniform_name = $request->uniform_name;
        $player->uniform_number = $request->uniform_number;
        $player->phone = $request->phone;
        $player->birthday = $request->birthday;
        $player->position = $request->position;
        $player->role = $request->role;
        $player->ismain = $request->ismain;
        if(isset($request->avatar)) $player->avatar = $request->avatar;
        if(isset($request->front_idcard)) $player->front_idcard = $request->front_idcard;
        if(isset($request->backside_idcard)) $player->backside_idcard = $request->backside_idcard;
        
        $player->save();
        
        Log::info('avatar'.$request->avatar);

        return redirect()->route('club.member', $request->slug);
    }

    public function setting($slug)
    {
        $club = Club::where('slug', $slug)->first();

        return view('clubs.setting', compact('club'));
    }

    public function update(Request $request, $slug){
        
        $club = Club::where('slug', $slug)->first();
        $clubs = Club::whereNotNull('slug')->get();
        // dd($request->all());
        $flag = true;
        if($club->name != $request->name){
            foreach($clubs as $clb){
                if($clb->name == $request->name){
                    $flag = false;
                }
            }
        }
        if($flag == true){
            $club->name = $request->name;
            $club->slug = Str::slug($club->name,'-');
            $club->gender = $request->gender;
            $club->ages = $request->ages;
            $club->club_type = $request->club_type;
            $club->phone = $request->phone;
            $club->email = $request->email;
            $club->description = $request->description;
            
            if(isset($request->logo)) $club->logo = $request->logo;
            if(isset($request->uniform)) $club->uniform = $request->uniform;
            
            Session::flash('update_club', 'Cập nhật thành công');
            $club->save();

        }else{
            Session::flash('name_false', 'Tên đội đã được sử dụng!');
        }

        return redirect()->back();
    }

    public function statistic($slug)
    {
        $club = Club::where('slug', $slug)->first();

        return view('clubs.statistic', compact('club'));
    }
}
