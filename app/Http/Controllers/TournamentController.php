<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use Illuminate\Support\Str;
use App\Tournament;
use App\User;
use Image;
use Log;
use Auth;
use Session;

class TournamentController extends Controller
{
    public function index()
    {   
        $tournaments = Tournament::whereNotNull('slug')
                                ->orderBy('created_at', 'DESC')
                                ->get();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;

        return view('tournaments.list', compact('tournaments', 'userID'));
    }
    /* Cắt logo */ 
    public function imageCrop(Request $request)
    {   
		// Log::info('start ');
        $image_file = $request->image;
        list($type, $image_file) = explode(';', $image_file);
        list(, $image_file) = explode(',', $image_file);
        $image_file = base64_decode($image_file);
        $image_name= time().'_'.rand(100,999).'.png';   
        $path = public_path('storage/logos/'.$image_name);
        file_put_contents($path, $image_file);

        return response()->json(['status'=>true, 'image_name'=>$image_name]);
    }

    /* View tạo mới giải đấu */
    public function create()
    {
        return view('tournaments.create');
    }
    /* Tạo mới giải đấu */
    public function store(TournamentRequest $request)
    {   
        // dd($request->all());
        // Lấy dữ liệu từ request
        $tournament = new Tournament();
        $tournament->owner_id = $request->owner_id;
        $tournament->name = $request->name;
        $tournament->slug = Str::slug($request->name,'-');
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
            $tournament->status = 3;    // trạng thái cho đăng ký
        }else{
            $tournament->register_permission = "off";
            $tournament->status = 2;    // trạng thái chưa kích hoạt
        }
        // Lưu
        $tournament->save();

        $user = User::where('id', $tournament->owner_id)->first();

        Session::flash('create_tournament', 'Tạo giải đấu thành công!');

        return redirect()->route('user.tournaments', $user->username);
    }

    /* View Tin chung */ 
    public function dashboard($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        $userID = isset(Auth::user()->id)?Auth::user()->id:0;

        return view('tournaments.dashboard', compact('tournament', 'userID'));
    }

    /* View danh sách đăng ký giải đấu */ 
    public function listRegister($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        $userID = isset(Auth::user()->id)?Auth::user()->id:0;

        return view('tournaments.list_register', compact('tournament', 'userID'));
    }

    /* View Vòng bảng */ 
    public function stageGroup($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        return view('tournaments.stage_group', compact('tournament', 'userID'));
    }

    /* View Vòng loại trực tiếp*/ 
    public function knockout($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        return view('tournaments.knockout', compact('tournament', 'userID'));
    }

    /* View Bảng xếp hạng */ 
    public function ranking($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        return view('tournaments.ranking', compact('tournament', 'userID'));
    }

    /* View Đội bóng */ 
    public function listClubs($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        return view('tournaments.list_club', compact('tournament', 'userID'));
    }

    /* View Thống kê */ 
    public function statistics($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        return view('tournaments.statistics', compact('tournament', 'userID'));
    }

    /* View Giới thiệu */ 
    public function about($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;

        return view('tournaments.about', compact('tournament', 'userID'));
    }

    public function search(Request $request)
    {
        $key = $request->search;
        $tournaments = Tournament::whereNotNull('slug')
                                ->orderBy('created_at', 'DESC')
                                ->get();

        if(isset($key)){
            $tournaments = Tournament::where('name', 'LIKE', '%'.$key.'%')
                                    ->orWhere('address', 'LIKE','%'.$key.'%')
                                    ->orWhere('stadium', 'LIKE','%'.$key.'%')
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
            if(count($tournaments) > 0){
                return view('tournaments.list', compact('tournaments'));
            }else{
                $tournaments = Tournament::whereNotNull('slug')
                                ->orderBy('created_at', 'DESC')
                                ->get();
                Session::flash('search_false', "Không tìm thấy kết quả");
            }
        }

        return view('tournaments.list', compact('tournaments'));
    }
}
