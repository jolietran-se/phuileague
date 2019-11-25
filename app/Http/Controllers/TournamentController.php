<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use App\Tournament;
use Image;
use Log;
use Auth;
use Session;

class TournamentController extends Controller
{
    public function index()
    {
        return view('tournaments.list');
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function store(TournamentRequest $request)
    {
        // dd($request->all());
        // Lấy dữ liệu từ request
        $tournament = new Tournament();
        $tournament->owner_id = $request->owner_id;
        $tournament->name = $request->name;
        $tournament->gender = $request->gender;
        $tournament->logo = $request->logo;
        $tournament->stadium = $request->stadium;
        $tournament->address = $request->address;
        $tournament->tournament_type_id = $type = $request->tournament_type_id;
        // Thêm các giá trị mà ở hình thức nào cũng có
        $tournament->number_club = $request->number_club; 
        $tournament->number_player = $request->number_player;
        // Thêm các giá trị chỉ có ở hình thức 2 và 3
        if($type != 01){
            $tournament->number_round = $request->number_round;
            $tournament->score_win = $request->score_win;
            $tournament->score_draw = $request->score_draw;
            $tournament->score_lose = $request->score_lose;
        }
        // Thêm các giá tị ở hình thức 3
        if($type == 03){
            $tournament->number_group = $request->number_group;
            $tournament->number_knockout = $request->number_knockout;
        }
        // Thêm quyền đăng ký
        if(isset($request->register_permission)){
            $tournament->register_permission = $request->register_permission;
            $tournament->register_date = $request->register_date;
        }else{
            $tournament->register_permission = "off";
        }
        // Lưu
        $tournament->save();

        Session::flash('create_tournament', 'Tạo giải đấu thành công!');

        return redirect()->route('home');
    }

    public function imageCrop(Request $request)
    {   
		// Log::info('start ');
        $image_file = $request->image;
        list($type, $image_file) = explode(';', $image_file);
        list(, $image_file)      = explode(',', $image_file);
        $image_file = base64_decode($image_file);
        $image_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/logos/'.$image_name);
        file_put_contents($path, $image_file);

        return response()->json(['status'=>true, 'image_name'=>$image_name]);
    }
}
