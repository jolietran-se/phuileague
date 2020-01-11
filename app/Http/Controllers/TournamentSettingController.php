<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use Illuminate\Support\Str;
use App\Tournament;
use App\ClubTournament;
use App\TournamentPlayer;
use App\User;
use App\Club;
use App\Group;
use App\Match;
use App\Goal;
use App\Card;
use Image;
use Log;
use Auth;
use Session;
use Response;
use Validator;

class TournamentSettingController extends Controller
{

    /* 1. View Thông tin chung */ 
    public function setting($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;

        return view('tournaments.setting', compact('tournament', 'userID'));
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
    public function updateSetting(Request $request, $slug)
    {   
        // dd($request->all());
        $tournament = Tournament::where('slug', $slug)->first();
        $tournaments = Tournament::whereNotNull('slug')->get();
        
        $flag = true;

        if($tournament->name != $request->name){
            foreach($tournaments as $tour){
                if($tour->name == $request->name){
                    $flag = false;
                }
            }
        }
        if($flag == true){
            // Thông tin cơ bản
            $tournament->name = $request->name;
            $tournament->slug = Str::slug($tournament->name,'-');
            $tournament->gender = $request->gender;
            $tournament->stadium = $request->stadium;
            $tournament->address = $request->address;
            // Điểm
            $tournament->score_win = $request->score_win;
            $tournament->score_draw = $request->score_draw;
            $tournament->score_lose = $request->score_lose;
            $tournament->max_player = $request->max_player;
            $tournament->number_group = $request->number_group;
            $tournament->number_knockout = $request->number_knockout;
            $tournament->register_date = $request->register_date;

            $this->checkDate($tournament);
            // Số cầu thủ , số vòng
            if(isset($request->number_player)) $tournament->number_player = $request->number_player;
            if(isset($request->number_round)) $tournament->number_round = $request->number_round;
            if(isset($request->logo)) $tournament->logo = $request->logo;
            if(isset($request->introduce)) $tournament->introduce = $request->introduce;
            
            $tournament->save();
            // File điều lệ
            if($request->file('charter') != null){
                $file = $request->file('charter');
                $type = $file->getClientMimeType();
                
                if($type == "application/pdf"){
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('storage/charters/'), $filename);
                    $tournament->charter = $filename;
                    $tournament->save();
                    Session::flash('update_tournament', 'Cập nhật thành công!');
                
                }else if($type != "application/pdf"){
                    Session::flash('error_type', 'Định dạng tệp không phải PDF!');
                }
            }else{
                Session::flash('update_tournament', 'Cập nhật thành công!');
            }
        }else{
            Session::flash('name_false', 'Tên giải đã được sử dụng!');
        }
        
        return redirect()->route('tournament.setting', $tournament->slug);
    }

    /* 2. View Trạng thái */ 
    public function status($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        return view('settings.status', compact('tournament'));
    }

    public function updateStatus($slug, $status){
        $tournament = Tournament::where('slug', $slug)->first();
        $tournament->status = $status;
        $tournament->save();
        
        Session::flash('update_status', 'Đã thay đổi trạng thái!');

        return response()->json(['status'=>true]);
    }
    /* 3. View quản lý đội bóng */ 
    public function clubs($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        $clubs = $tournament->clubs()->where('status', 1)->get();

        return view('settings.clubs', compact('tournament', 'clubs'));
    }
    /* 4. View sắp xếp bảng đấu */ 
    public function groupstage($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $groups = Group::where('tournament_id', $tournament->id)->get();
        $clubs = ClubTournament::where('tournament_id', $tournament->id)->get();

        return view('settings.group_stage', compact('tournament', 'groups', 'clubs'));
    }
    
    // Sắp xếp lại bảng đấu
    public function sortGroup(Request $request, $slug){
        Log::info('start');
        $tournament = Tournament::where('slug', $slug)->first();                    // giải đấu
        $clubs = ClubTournament::where('tournament_id', $tournament->id)->get();    // danh sách đội bóng tham gia giải
        $groups = Group::where('tournament_id', $tournament->id)->get();            // danh sách các bảng đấu của giải

        // Lưu lại bảng đấu
        foreach($clubs as $club){
            foreach ($request->order as $order) {
                if($club->club_id == $order['id']){
                    $club->group_id = $order['groupID'];
                    $club->save();
                }
            }
        }

        // Xóa các trận đấu cũ, kết quả
        $matchs = $tournament->matchs()->get();
        foreach($matchs as $match){
            $goals = $match->goals()->delete();
            $cards = $match->cards()->delete();
        }
        $matchs =  $tournament->matchs()->delete();

        // Đếm lại số đội mỗi bảng, số trận mỗi bảng
        foreach($groups as $group){
            $group_clubs = ClubTournament::where('tournament_id', $tournament->id)
                                        ->where('group_id', $group->id)
                                        ->get();
            $group->number_club = count($group_clubs);
            $group->number_match = count($group_clubs)*(count($group_clubs)-1)/2;
            // Số đội vào vòng knockout
            foreach($request->knockout as $knockout){
                if($group->id == $knockout['groupID']){
                    $group->number_to_knockout = $knockout['number'];
                }
            }
            if(count($group_clubs) % 2 == 0){
                $group->number_round = count($group_clubs)-1;
            }else{
                $group->number_round = count($group_clubs);
            }
            
            $group->save();
        }
        // Xếp cặp thi đấu mới: 
        for ($round=0; $round < $tournament->number_round ; $round++) {
            $max_group_round = $groups->max('number_round');
            $max_tour_round = $max_group_round*$tournament->number_round; 
            Log::info('tour-round'.$round);

            foreach($groups as $group){
                $group_clubs = ClubTournament::where('tournament_id', $tournament->id)
                                            ->where('group_id', $group->id)
                                            ->get();
                $n = count($group_clubs);
                if($n % 2 == 0) {
                    for($j=1; $j<=$group->number_round; $j++){
                        $exits = array();
                        for($i=1; $i<= $n; $i++){
                            // Lập lịch với số đội là 2n
                            $r = $j;        // số vòng đấu
                            $m = $n-1;      // số chia
                            $sum = $r+$m;   // tổng x và y 
                            $x = $i;        // x
                            if(!in_array($x, $exits)){
                                $y = $sum-$x;
                                if($x == $y){
                                    $y = $n;
                                }elseif($y>$n){
                                    $y = $r-$x;
                                }
                                $exits[] = $x;
                                $exits[] = $y;
                                // if($x!=$y){
                                if($x!=$y && $j+$max_group_round*$round <= $max_tour_round){
                                    // Tạo mới trận đấu
                                    $match = new Match();
                                    $match->tournament_id = $tournament->id;
                                    $match->group_id = $group->id;
                                    $match->stage = "G";
                                    // $match->round = $j;
                                    $match->round = $j+$max_group_round*$round;
                                    $match->clubA_id = $group_clubs[$x-1]->club_id;
                                    $match->clubB_id = $group_clubs[$y-1]->club_id;
                                    $match->status = "active";
                                    $match->save();
                                }
                            }
                        }
                    }
                }else{
                    $n = $n+1;
                    $t = "";
                    Log::info($group->number_round);
                    for($j=1; $j<=$group->number_round; $j++){
                        $exits1 = array();
                        for($i=1; $i<= $n; $i++){
                            $r = $j;        
                            $m = $n-1;      
                            $sum = $r+$m;   
                            $x = $i;
                            if(!in_array($x, $exits1)){
                                $y = $sum-$x;
                                if($x == $y){
                                    $y = $n;
                                }elseif($y>$n){
                                    $y = $r-$x;
                                }
                                $exits1[] = $x;
                                $exits1[] = $y;

                                // if($x!=$y && $x!=$n && $y!=$n){
                                if($x!=$y && $x!=$n && $y!=$n && $j+$max_group_round*$round <= $max_tour_round){
                                    $t = $t."round: $j ".$x.$y."|";
                                    Log::info("round: $j ".$x.$y."|");
                                    // Tạo mới trận đấu
                                    $match = new Match();
                                    $match->tournament_id = $tournament->id;
                                    $match->group_id = $group->id;
                                    $match->stage = "G";
                                    // $match->round = $j;
                                    $match->round = $j+$max_group_round*$round;
                                    $match->clubA_id = $group_clubs[$x-1]->club_id;
                                    $match->clubB_id = $group_clubs[$y-1]->club_id;
                                    $match->status = "active";
                                    $match->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        Session::flash('group_stage', 'Cập nhật thành công');

        return response()->json(['status'=>true]);
    }

    /* 5. View sắp xếp cặp đấu */ 
    public function matchstage($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $groups = $tournament->groups()->get();
        $clubs = $tournament->clubs()->get();
        $matchsG = $tournament->matchs()->where('stage', 'G')->get();
        // dd($matchsG);
        $number_round = $tournament->groups()->max('number_round');

        // các đội vào vòng knockout
        $clubsToKnockout = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('group_id')
                                                ->orderBy('g_point', 'desc')
                                                ->get();
        $knockoutClubsRanking = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('k_point', 'desc')
                                                ->get();
        // số lượt thi đấu:
        $number_knockout = $tournament->number_knockout; 
        $k_rounds = (int) (log10($number_knockout)/log10(2));
        for ($i=$k_rounds; $i >=1; $i--){
            // số dội tại lượt i:
            $t = 0;
            $n_club = pow(2, $i);
            $n_match = $n_club/2;
            $matchsKn = $tournament->matchs()->where('stage', 'K')->where('round', $n_club)->get();
            if (count($matchsKn) === 0) {
                if ($i==$k_rounds) {
                    // Sắp xếp cặp đấu ở lượt đầu của vòng loại
                    $clubsKn = $clubsToKnockout->take($n_club);
                    $existClub = array();
                    foreach($clubsKn as $key => $club){
                        if (!in_array($key, $existClub)) {
                            $existClub[] = $key;
                            $existClub[] = $n_club-$key-1;
                            $match = new Match();
                            $match->tournament_id = $tournament->id;
                            $match->stage = "K";
                            $match->round = $n_club;
                            $match->clubA_id = $clubsKn[$key]->id;
                            $match->clubB_id = $clubsKn[$n_club-$key-1]->id;
                            $match->save();
                        }
                    }
                }else{
                    // Sắp xếp cặp đấu ở lượt các lượt sau của vòng loại
                    for ($i=1; $i <=$n_match ; $i++){ 
                        $match = new Match();
                        $match->tournament_id = $tournament->id;
                        $match->stage = "K";
                        $match->round = $n_club;
                        $match->clubA_id = 0;
                        $match->clubB_id = 0;
                        $match->save();
                    }
                }
            }
        }
        $matchsK = $tournament->matchs()->where('stage', 'K')->get();

        return view('settings.match_stage', compact('tournament', 'groups',  'clubs', 'matchsG', 'matchsK', 'number_round', 'k_rounds', 'clubsToKnockout', 'knockoutClubsRanking'));
    }
    // Sắp xếp lại cặp đấu
    public function saveStageRound(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        if(isset($request->matchsG)){
            foreach($request->matchsG as $match){
                $obj = $tournament->matchs()->where('id', $match['matchId'])->first();
                $obj->clubA_id = $match['clubA_id'];
                $obj->clubB_id = $match['clubB_id'];
                $obj->save();
            }
        }
        if (isset($request->matchsK)){
            foreach($request->matchsK as $match){
                $obj = $tournament->matchs()->where('id', $match['matchId'])->first();
                $obj->clubA_id = $match['clubA_id'];
                $obj->clubB_id = $match['clubB_id'];
                $obj->save();
            }
        }

        Session::flash('match_stage', 'Cập nhật thành công');

        return response()->json(['status'=>true]);
    }

    /* 6. View quản lý lịch đấu */ 
    public function schedule($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        $groups = $tournament->groups()->get();
        $clubs = $tournament->clubs()->get();
        // Vòng bảng
        $matchsG = $tournament->matchs()->where('stage', 'G')->get();
        $g_round = $tournament->groups()->max('number_round');
        // Vòng loại trực tiếp
        $matchsK = $tournament->matchs()->where('stage', 'K')->get();
        $k_round = (int) (log10($tournament->number_knockout)/log10(2));
        $clubsToKnockout = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('group_id')
                                                ->orderBy('g_point', 'desc')
                                                ->get();
        $knockoutClubsRanking = $tournament->clubs()->wherePivot('isnext', 1)
                                                ->orderBy('k_point', 'desc')
                                                ->get();
        return view('settings.schedule', compact('tournament', 'groups', 'clubs', 'matchsG', 'g_round', 'matchsK', 'k_round', 'clubsToKnockout', 'knockoutClubsRanking'));
    }

    public function saveSchedule(Request $request, $slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        foreach($request->schedules as $schedule){
            $obj = $tournament->matchs()->where('id', $schedule['matchId'])->first();
            $obj->address = $schedule['address'];
            $obj->date = $schedule['date'];
            $obj->time = $schedule['time'];
            $obj->save();
        }

        Session::flash('save_schedule', 'Cập nhật thành công');

        return response()->json(['status'=>true]);
    }
    /*7.  View Quy tắc xếp hạng */ 
    public function rankingrule($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.ranking_rule', compact('tournament'));
    }
    /* 8. View Nhà tài trợ */ 
    public function supporter($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.supporter', compact('tournament'));
    }

    public function checkDate($tournament)
    {
        // Ngày hiện tại
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
}
