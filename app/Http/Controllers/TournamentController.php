<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use App\Tournament;
use App\Group;
use App\User;
use App\Club;
use App\Player;
use App\Goal;
use App\Match;
use App\Card;
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
        // Thêm các giá trị ở hình thức 3
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
        
        if($tournament->status != 4){
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
    // Đăng ký tham gia
    public function signUp(RegisterRequest $request, $slug)
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
            Session::flash('signup_success', "Đăng ký thành công");
        }else{
            Session::flash('signup_fail', "Đội bóng đã nằm trong danh sách đăng ký");
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
        
        // Tổng số đội tham gia giải đấu
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
        $allowClubs = ClubTournament::where('tournament_id', $tournament->id)
                                    ->where('status', 1)
                                    ->get();
        if (count($allowClubs)< 6 || count($allowClubs)/$tournament->number_group<3 ) {
            Session::flash('no-end-signup', 'Số đội bóng không thể nhỏ hơn 6 hoặc mỗi bảng đấu không thể có ít hơn 3 đội!');

            return response()->json(['status'=>false]);
        }else{
            // Xóa các đội đã bị từ chối
            $rejectClubs = ClubTournament::where('tournament_id', $tournament->id)
                                    ->where('status', 0)
                                    ->orWhere('status', 2)
                                    ->get();
            foreach($rejectClubs as $club){
                $club->delete();
            }
            
            /* SẮP XẾP BẢNG ĐẤU*/
            if( $tournament->tournament_type_id == 3){
                // Số đội mỗi bảng, số bảng đấu
                $n = $tournament->number_club;
                $m = $tournament->number_group;

                $groups = Group::where('tournament_id', $tournament->id)->get();
                foreach($groups as $group){
                    $group->delete();
                }
                $alpha = range('A', 'Z');
                
                if ($n % $m == 0) {
                    $n_club = $n/$m;
                    $n_match = $n_club*($n_club-1)/2;
                    // Thêm mới các bảng:
                    for ($i=0; $i < $m ; $i++) { 
                        $group = new Group();
                        $group->tournament_id = $tournament->id;
                        $group->name = $alpha[$i];
                        $group->save();
                    }
                    $groups = Group::where('tournament_id', $tournament->id)->get();
                    foreach ($groups as $group) {
                        $group->number_match = $n_match;
                        $group->number_club = $n_club;
                        $group->number_round = $n_match*2/$n_club;
                        $group->save();
                    }
                }else if($n % $m != 0){
                    $n_club =floor($n/$m);
                    $j = $n % $m;
                    // m-j bảng đầu sẽ có $n_club đội, j bảng cuối có $n_club+1 đội 
                    $n_club_mj = $n_club;
                    $n_club_j = $n_club+1;
                    // Số trận: 
                    $n_match = pow($n_club, 2);
                    // Thêm mới các bảng:
                    for ($i=0; $i < $m ; $i++) { 
                        $group = new Group();
                        $group->tournament_id = $tournament->id;
                        $group->name = $alpha[$i];
                        $group->save();
                    }
                    $groups = Group::where('tournament_id', $tournament->id)->get();
                    foreach ($groups as $key => $group) {
                        if($key < $m-$j){
                            $group->number_club = (int) $n_club;
                            $group->number_match = (int) $n_club*($n_club-1)/2;
                        }else{
                            $group->number_club = (int)  $n_club+1;
                            $group->number_match = (int) $n_club*($n_club+1)/2;
                        }
                        $group->save();
                    }
                }
                // Danh sách id các bảng đấu
                $groups = Group::where('tournament_id', $tournament->id)->get();
                $groupIDs = array();
                foreach ($groups as $group) {
                    for($i=0; $i<$group->number_club; $i++){
                        $groupIDs[] = $group->id;
                    }
                }
                // Xếp các đội vào các bảng
                $clubs = ClubTournament::where('tournament_id', $tournament->id)->get();
                // dd($clubs);
                foreach($clubs as $key => $club){
                    $club->group_id = $groupIDs[$key];
                    $club->save();
                }
            }

            // Thay đổi trạng thái
            $tournament->status = 4;
            $tournament->register_permission = "off";
            $tournament->save();
            Session::flash('end-signup', 'Giải đấu đã chuyển sang trạng thái hoạt động!');

            return response()->json(['status'=>true]);
        }
    }
    
    /* View Vòng bảng */ 
    public function stageGroup($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        
        $groups = $tournament->groups()->get();
        $matchs = $tournament->matchs()->where('stage','G')->get();
        $clubs = $tournament->clubs()->get();

        return view('tournaments.stage_group', compact('tournament', 'userID', 'groups', 'matchs', 'clubs'));
    }
    public function saveMatchResult(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $match = $tournament->matchs()->where('id', $request->matchId)->first();
        $goalsOfMatch = $request->goalsOfMatch;
        // Thay đổi trạng thái trận đấu:
        $match->status = "close";
        $match->goalA = $goalsOfMatch[0]['goalA'];
        $match->goalB = $goalsOfMatch[0]['goalB'];
        $match->sub_goal_A = $goalsOfMatch[0]['subGoalA'];
        $match->sub_goal_B = $goalsOfMatch[0]['subGoalB'];
        $match->yellow_card_A = $goalsOfMatch[0]['yellow_card_A'];
        $match->yellow_card_B = $goalsOfMatch[0]['yellow_card_B'];
        $match->red_card_A = $goalsOfMatch[0]['red_card_A'];
        $match->red_card_B = $goalsOfMatch[0]['red_card_B'];
        $match->save();
        // Xóa những bàn thắng cũ
        $match->goals()->delete();
        $match->cards()->delete();
        // Lưu các bàn thắng
        if(is_array($request->goalsOfA) || is_object($request->goalsOfA)){
            foreach($request->goalsOfA as $goalA){
                $goal = new Goal();
                $goal->match_id = $goalA['matchId'];
                $goal->club_id = $goalA['clubId'];
                $goal->player_id = $goalA['playerId'];
                $goal->goal_time = $goalA['goalTime'];
                $goal->isowngoal = $goalA['isOwnGoal'];
                $goal->created_at = null;
                $goal->updated_at = null;
                $goal->save();
            }
        }
        if(is_array($request->goalsOfB) || is_object($request->goalsOfB)){
            foreach($request->goalsOfB as $goalB){
                $goal = new Goal();
                $goal->match_id = $goalB['matchId'];
                $goal->club_id = $goalB['clubId'];
                $goal->player_id = $goalB['playerId'];
                $goal->goal_time = $goalB['goalTime'];
                $goal->isowngoal = $goalB['isOwnGoal'];
                $goal->created_at = null;
                $goal->updated_at = null;
                $goal->save();
            }
        }
        // Lưu thẻ vàng 
        if(is_array($request->yellowsOfA) || is_object($request->yellowsOfA)){
            foreach($request->yellowsOfA as $yellowA){
                $yellow = new Card();
                $yellow->match_id = $yellowA['matchId'];
                $yellow->club_id = $yellowA['clubId'];
                $yellow->player_id = $yellowA['playerId'];
                $yellow->card_time = $yellowA['cardTime'];
                $yellow->isredcard = $yellowA['isRedCard'];
                $yellow->created_at = null;
                $yellow->updated_at = null;
                $yellow->save();
            }
        }
        if(is_array($request->yellowsOfB) || is_object($request->yellowsOfB)){
            foreach($request->yellowsOfB as $yellowB){
                $yellow = new Card();
                $yellow->match_id = $yellowB['matchId'];
                $yellow->club_id = $yellowB['clubId'];
                $yellow->player_id = $yellowB['playerId'];
                $yellow->card_time = $yellowB['cardTime'];
                $yellow->isredcard = $yellowB['isRedCard'];
                $yellow->created_at = null;
                $yellow->updated_at = null;
                $yellow->save();
            }
        }
        // Lưu thẻ đỏ
        if(is_array($request->redsOfA) || is_object($request->redsOfA)){
            foreach($request->redsOfA as $redA){
                $red = new Card();
                $red->match_id = $redA['matchId'];
                $red->club_id = $redA['clubId'];
                $red->player_id = $redA['playerId'];
                $red->card_time = $redA['cardTime'];
                $red->isredcard = $redA['isRedCard'];
                $red->created_at = null;
                $red->updated_at = null;
                $red->save();
            }
        }
        if(is_array($request->redsOfB) || is_object($request->redsOfB)){
            foreach($request->redsOfB as $redB){
                $red = new Card();
                $red->match_id = $redB['matchId'];
                $red->club_id = $redB['clubId'];
                $red->player_id = $redB['playerId'];
                $red->card_time = $redB['cardTime'];
                $red->isredcard = $redB['isRedCard'];
                $red->created_at = null;
                $red->updated_at = null;
                $red->save();
            }
        }
        
        /* Tính lại điểm và bảng xếp hạng:*/
        // Tính điểm vòng bảng
        $matchsG = $tournament->matchs()->where('stage', 'G')->get();
        $clubsG = ClubTournament::where('tournament_id', $tournament->id)->get();
        foreach($clubsG as $club){
            $number_match = 0;
            $number_win = $number_draw = $number_lost = 0;
            $goal_for = $goal_against = 0;
            $number_yellow = $number_red = 0;
            foreach($matchsG as $match){
                if($match->clubA_id == $club->club_id){
                    if($match->goalA!==null && $match->goalB!==null){
                        $number_match+=1;
                        if ($match->goalA > $match->goalB) $number_win++;
                        elseif($match->goalA == $match->goalB) $number_draw++;
                        elseif($match->goalA < $match->goalB) $number_lost++;
                    }  
                    $goal_for +=  $match->goalA;
                    $goal_against +=  $match->goalB;
                    $number_yellow += $match->yellow_card_A;
                    $number_red += $match->red_card_A;
                }
                if($match->clubB_id == $club->club_id){
                    if($match->goalA!==null && $match->goalB!==null){
                        $number_match+=1;
                        if($match->goalB > $match->goalA) $number_win++;
                        elseif($match->goalB == $match->goalA) $number_draw++;
                        elseif($match->goalb < $match->goalA) $number_lost++;
                    }
                    $goal_for +=  $match->goalB;
                    $goal_against +=  $match->goalA;
                    $number_yellow += $match->yellow_card_B;
                    $number_red += $match->red_card_B;
                }
            }
            $point = $number_win*$tournament->score_win + $number_draw*$tournament->score_draw + $number_lost*$tournament->score_lose;
            $club->g_number_match = $number_match;
            $club->g_number_win = $number_win;
            $club->g_number_draw = $number_draw;
            $club->g_number_lost = $number_lost;
            $club->g_point = $point;
            $club->g_number_yellow = $number_yellow;
            $club->g_number_red = $number_red;
            $club->g_goal_for =  $goal_for;
            $club->g_goal_against = $goal_against;
            $club->g_goal_diff = $goal_for - $goal_against;
            $club->save();
        }
        // Tính điểm vòng loại trực tiếp:
        $matchsK = $tournament->matchs()->where('stage', 'K')->get();
        $clubsK = ClubTournament::where('tournament_id', $tournament->id)->where('isnext',1)->get();
        foreach($clubsK as $club){
            $number_match = 0;
            $number_win = $number_draw = $number_lost = 0;
            $goal_for = $goal_against = 0;
            $number_yellow = $number_red = 0;
            foreach($matchsK as $match){
                if($match->clubA_id == $club->club_id){
                    if($match->goalA!==null && $match->goalB!==null){
                        $number_match+=1;
                        if ($match->goalA > $match->goalB) $number_win++;
                        elseif($match->goalA == $match->goalB && $match->sub_goal_A > $match->sub_goal_B) $number_win++;
                        elseif($match->goalA == $match->goalB && $match->sub_goal_A < $match->sub_goal_B) $number_lost++;
                        elseif($match->goalA < $match->goalB) $number_lost++;
                    }  
                    $goal_for +=  $match->goalA;
                    $goal_against +=  $match->goalB;
                    $number_yellow += $match->yellow_card_A;
                    $number_red += $match->red_card_A;
                }
                if($match->clubB_id == $club->club_id){
                    if($match->goalA!==null && $match->goalB!==null){
                        $number_match+=1;
                        if($match->goalB > $match->goalA) $number_win++;
                        elseif($match->goalB == $match->goalA && $match->sub_goal_B > $match->sub_goal_A) $number_win++;
                        elseif($match->goalB == $match->goalA && $match->sub_goal_B < $match->sub_goal_A) $number_lost++;
                        elseif($match->goalb < $match->goalA) $number_lost++;
                    }
                    $goal_for +=  $match->goalB;
                    $goal_against +=  $match->goalA;
                    $number_yellow += $match->yellow_card_B;
                    $number_red += $match->red_card_B;
                }
            }
            $point = $number_win*$tournament->score_win + $number_draw*$tournament->score_draw + $number_lost*$tournament->score_lose;
            $club->k_number_match = $number_match;
            $club->k_number_win = $number_win;
            $club->k_number_draw = $number_draw;
            $club->k_number_lost = $number_lost;
            $club->k_point = $point;
            $club->k_number_yellow = $number_yellow;
            $club->k_number_red = $number_red;
            $club->k_goal_for =  $goal_for;
            $club->k_goal_against = $goal_against;
            $club->save();
        }

        Session::flash('save_result', 'Kết quả đã được cập nhật!');

        return response()->json(['status'=>true]);
    }

    /* View Vòng loại trực tiếp*/ 
    public function stageKnockout($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        $matchsK = $tournament->matchs()->where('stage','K')->get();
        $groups = $tournament->groups()->get();
        $clubs = $tournament->clubs()->get();
        $k_rounds = (int) (log10($tournament->number_knockout)/log10(2));

        $clubsToKnockout = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('group_id')
                                                ->orderBy('g_point', 'desc')
                                                ->get();
        $knockoutClubsRanking = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('group_id')
                                                ->orderBy('k_point', 'desc')
                                                ->get();
        // dd($matchs);
        return view('tournaments.knockout', compact('tournament', 'userID', 'groups', 'k_rounds', 'matchsK', 'clubs', 'clubsToKnockout', 'knockoutClubsRanking'));
    }

    /* View Bảng xếp hạng */ 
    public function ranking($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
        // Vòng bảng:
        $groups = $tournament->groups()->get();
        $groupClubsRanking = ClubTournament::where('tournament_id', $tournament->id)
                                            ->orderBy('g_point', 'desc')
                                            ->orderBy('g_goal_diff', 'desc')
                                            ->orderBy('g_number_yellow', 'asc')
                                            ->get();

        $knockoutClubsRanking = $tournament->clubs()->wherePivot('isnext', 1)
                                            ->orderBy('k_point', 'desc')
                                            ->get();    
        
        return view('tournaments.ranking', compact('tournament', 'userID', 'groups', 'groupClubsRanking', 'knockoutClubsRanking'));
    }
    public function savePassGroup(Request $request, $slug)
    {   
        Log::info($request->all());
        $tournament = Tournament::where('slug', $slug)->first();
        if(is_array($request->passClubs) || is_object($request->passClubs)){
            foreach($request->passClubs as $club){
                $clubTournament = ClubTournament::where('id', $club['clubId'])->first();
                $clubTournament->isnext = $club['isNext'];
                $clubTournament->g_rank = $club['rank'];
                $clubTournament->save();
            }
        }
        // Xóa các kết quả hiện có của vòng loại trực tiếp
        $matchsK = $tournament->matchs()->where('stage', 'K')->get();
        foreach($matchsK as $match){
            $match->delete();
            $match->goals()->delete();
            $match->cards()->delete();
        }
        
        return response()->json(['status'=>true]);
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
