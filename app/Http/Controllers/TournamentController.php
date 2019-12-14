<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use App\Tournament;
use App\User;
use App\Club;
use App\Player;
use App\ClubTournament;
use App\TournamentPlayer;
use Image;
use Log;
use Auth;
use Response;
use Session;

class TournamentController extends Controller
{
    public function index()
    {   
        $tournaments = Tournament::whereNotNull('slug')
                                ->orderBy('created_at', 'DESC')
                                ->get();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        // Kiểm tra hạn đăng ký
        foreach($tournaments as $tournament){
            $this->checkDate($tournament);
        }
        
        return view('tournaments.list', compact('tournaments', 'userID'));

    }
    public function checkDate($tournament){
        // Điều chỉnh trang thái theo ngày đăng ký
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date("d-m-Y");
        if($tournament->status != 4){
            // Kiểm tra xem đã hết hạn chưa
            if(strtotime($tournament->register_date) < strtotime($today)){
                $tournament->register_permission = "off";
                if($tournament->status == 3) $tournament->status = "2";
            }else{
                $tournament->register_permission = "on";
                if($tournament->status == 2) $tournament->status = "3";
            }
            $tournament->save();
        }
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
        $userClubs = Club::where('owner_id', $userID)->get();
        
        if($tournament->status !=4){
            $this->checkDate($tournament);
        }
        
        $considerClubs = $tournament->clubs()->where('status', 0)->get();
        $allowClubs = $tournament->clubs()->where('status', 1)->get();
        $rejectClubs = $tournament->clubs()->where('status', 2)->get();
        $number_consider = count($considerClubs);
        $number_allow = count($allowClubs);
        $number_reject = count($rejectClubs);
        
        return view('tournaments.list_register', compact('tournament', 'userID', 'userClubs', 'number_consider', 'number_allow', 'number_reject'));
    }

    public function register(RegisterRequest $request, $slug)
    {   
        $tournament = Tournament::where('slug', $slug)->first();

        $registed = ClubTournament::where('tournament_id', $tournament->id)->get();

        $flag = true;
        foreach ($registed as $club){
            if($club->club_id == $request->club_id) $flag = false;
        }
        if($flag == true){
            $club_tour = new ClubTournament();
            $club_tour->tournament_id = $tournament->id;
            $club_tour->club_id = $request->club_id;
            $club_tour->status = 0; // trạng thái chờ phê duyệt
            $club_tour->save();
            Session::flash('register_success', "Đăng ký thành công");
        }else{
            Session::flash('register_fail', "Đội bóng đã nằm trong danh sách đăng ký");
        }
        
        return redirect()->route('tournament.listregister', $tournament->slug);
    }
    // Cho phép tham gia
    public function actionAllow(Request $request, $slug)
    {

        $clubID = $request->clubID;
        $tournamentID = $request->tournamentID;
        // Lưu đội bóng vào danh sách
        $club_tournament = ClubTournament::where('tournament_id', $tournamentID)
                                            ->where('club_id', $clubID)
                                            ->first();
        $club_tournament->status = 1;
        $club_tournament->save();
        
        // Lưu thông tin các cầu thủ trong đội hình chính
        $players = Player::where('club_id', $clubID)
                            ->where('ismain', 1)
                            ->orderBy('uniform_number')
                            ->get();
        if(count($players) != 0){
            foreach ($players as $player) {
                $tournament_player = new TournamentPlayer();
                $tournament_player->club_tournament_id = $club_tournament->id ;
                $tournament_player->player_id = $player->id ;
                $tournament_player->name = $player->name ;
                $tournament_player->avatar = $player->avatar ;
                $tournament_player->front_idcard = $player->front_idcard ;
                $tournament_player->backside_idcard = $player->backside_idcard ;
                $tournament_player->uniform_number = $player->uniform_number ;
                $tournament_player->uniform_name = $player->uniform_name ;
                $tournament_player->position = $player->position ;
                $tournament_player->role = $player->role ;
                $tournament_player->phone = $player->phone ;
                $tournament_player->birthday = $player->birthday ;
                $tournament_player->save();
            }
        }
        // tổng số đội tham gia giải đấu
        $clubs = ClubTournament::where('tournament_id', $tournamentID)
                                ->where('status', 1)
                                ->get();
        $tournament = Tournament::where('slug', $slug)->first();
        $tournament->number_club = count($clubs);
        $tournament->save();

        return response()->json(['status'=>true, 'clubId'=> $club_tournament->club_id]);
    }
    
    // Từ chối tham gia
    public function actionReject(Request $request, $slug)
    {

        $clubID = $request->clubID;
        $tournamentID = $request->tournamentID;

        $club_tournament = ClubTournament::where('tournament_id', $tournamentID)
                                            ->where('club_id', $clubID)
                                            ->first();
        $club_tournament->status = 2;
        $club_tournament->save();
        
        // Xóa thông tin các cầu thủ tham gia giải
        $players = TournamentPlayer::where('club_tournament_id', $club_tournament->id)->get();
        if(count($players)!=0){
            foreach ($players as $player) {
                $player->delete();
            }
        }
        // tổng số đội tham gia giải đấu
        $clubs = ClubTournament::where('tournament_id', $tournamentID)
                                ->where('status', 1)
                                ->get();
        $tournament = Tournament::where('slug', $slug)->first();
        $tournament->number_club = count($clubs);
        $tournament->save();

        return response()->json(['status'=>true, 'clubId'=> $club_tournament->club_id]);
    }
    // Hủy đăng ký
    public function cancelSignUp(Request $request, $slug)
    {
        $clubID = $request->clubID;
        $tournamentID = $request->tournamentID;

        $club_tournament = ClubTournament::where('tournament_id', $tournamentID)
                                            ->where('club_id', $clubID)
                                            ->delete();
        return response()->json(['status'=>true]);
    }
    // Kết thúc đăng ký
    public function endSignUp(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $tournament->status = 4;
        $tournament->register_permission = "off";
        
        $clubs = ClubTournament::where('tournament_id', $tournament->id)->get();
        foreach($clubs as $club){
            if($club->status != 1) $club->delete();
        }
        $tournament->save();

        Session::flash('end-sign-up', 'Giải đấu đã chuyển sang trạng thái hoạt động!');

        return response()->json(['status'=>true]);
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
        $clubs = $tournament->clubs()->where('status', 1)->get();
        
        return view('tournaments.list_club', compact('tournament', 'userID', 'clubs'));
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

    public function exportChater($slug, $charter){
        // dd(1);
        $pathToFile = public_path('storage/charters/'.$charter);
        // dd($charter);
        return Response::make(file_get_contents($pathToFile), 200, [
            'Content-Type'=> 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$charter.'"'
        ]);
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
