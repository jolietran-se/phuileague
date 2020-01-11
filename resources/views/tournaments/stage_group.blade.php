@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">

@endsection

@section('content')
    <div class="header-tournament">
        <div class="container">
            <!-- Tournament Information Title-->
            @include('layouts.tournament')
            <!-- Header TabList -->
            <div id="tablist-header" class="tablist">
                <ul class="nav nav-tabs">
                    @if ($userID == $tournament->owner_id)
                        <li role="presentation"><a href="{{ route('tournament.setting', $tournament->slug)}}">Tùy chỉnh</a></li>
                        {{-- <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        {{-- <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @else 
                        {{-- <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        {{-- <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="setting-section setting-main">
        @if ($tournament->tournament_type_id == 3)
        <div class="container" id="content">
            <div class="col-md-12">
                <small><b>Giai đoạn đấu vòng tròn có:</b> {{ count($groups) }} bảng đấu và {{ $groups->sum('number_match')*$tournament->number_round }} trận đấu thi đấu trong {{ $tournament->number_round }} lượt.</small><br>
                <small><b>Giai đoạn đấu loại trực tiếp có: </b>{{ $tournament->number_knockout }} đội vượt qua vòng bảng và {{ $tournament->number_knockout - 1 }} trận đấu.</small>
                <hr>
            </div>
            <div class="col-md-12" id="list-match">
                @php $index = 1; @endphp
                @for($i=1; $i<= $groups->max('number_round')*$tournament->number_round; $i++)
                    <div id="round{{$i}}" class="round-area col-md-12 tab-item">
                        <div class="round-label"><p class="text-center">VÒNG {{ $i }}</p></div>
                        <table class="table table-striped">
                            @foreach ($groups as $group)
                                @foreach ($matchs as $match)
                                    @if ($match->round == $i && $match->group_id == $group->id && $match->stage=="G")
                                        <datalist id="players-a-{{$match->id}}">
                                            @foreach ($clubs->where('id',$match->clubA_id)->first()->players()->where('ismain',1)->get() as $player)
                                                <option data-id="{{$player->id}}" value="{{ $player->name }}"></option>
                                            @endforeach
                                        </datalist>
                                        <datalist id="players-b-{{$match->id}}">
                                            @foreach ($clubs->where('id',$match->clubB_id)->first()->players()->where('ismain',1)->get() as $player)
                                                <option data-id="{{ $player->id }}" value="{{ $player->name }}"></option> 
                                            @endforeach
                                        </datalist>
                                        <tr class="show-detail show-detail-{{$match->id}}" id="show-match-{{$match->id}}" role="button" 
                                            data-match-id="{{ $match->id }}"
                                            data-a-id="{{ $match->clubA_id }}"
                                            data-b-id="{{ $match->clubB_id }}"
                                            data-a-name="{{ $clubs->where('id', $match->clubA_id)->first()->name }}"
                                            data-b-name="{{ $clubs->where('id', $match->clubB_id)->first()->name }}"
                                            data-a-logo="{{ $clubs->where('id', $match->clubA_id)->first()->logo }}"
                                            data-b-logo="{{ $clubs->where('id', $match->clubB_id)->first()->logo }}"
                                            data-a-goal="{{ $match->goalA }}"
                                            data-b-goal="{{ $match->goalB }}"
                                            data-a-yellow="{{ $match->yellow_card_A }}"
                                            data-b-yellow="{{ $match->yellow_card_B }}"
                                            data-a-red="{{ $match->red_card_A }}"
                                            data-b-red="{{ $match->red_card_B }}"
                                            data-address="{{ $match->address }}"
                                            data-date="{{ $match->date }}"
                                            data-time="{{ $match->time }}"
                                            data-stage="{{ $match->stage }}"
                                            data-round="{{ $match->round }}"
                                            data-list-goal-a = {{ $match->goals()->where('club_id', $match->clubA_id)->get() }}
                                            data-list-goal-b = {{ $match->goals()->where('club_id', $match->clubB_id)->get() }}
                                            data-list-yellow-a = {{ $match->cards()->where('club_id', $match->clubA_id)->where('isredcard', 0)->get() }}
                                            data-list-yellow-b = {{ $match->cards()->where('club_id', $match->clubB_id)->where('isredcard', 0)->get() }}
                                            data-list-red-a = {{ $match->cards()->where('club_id', $match->clubA_id)->where('isredcard', 1)->get() }}
                                            data-list-red-b = {{ $match->cards()->where('club_id', $match->clubB_id)->where('isredcard', 1)->get() }}
                                        >
                                            <td style="width:20%"><small>#{{$index}}  Bảng {{$group->name}}</small></td>
                                            <td style="width:25%" class="text-right">
                                                <small>{{ $clubs->where('id', $match->clubA_id)->first()->name }}</small>
                                                @if (isset($clubs->where('id', $match->clubA_id)->first()->logo))
                                                    <img src="{{ asset('storage/club-logos/').'/'.$clubs->where('id', $match->clubA_id)->first()->logo }}" alt="" class="img-circle" style="width:30px">
                                                @else 
                                                    <img src="{{ asset('storage/club-logos/logo_default.jpg') }}" alt="" class="img-circle" style="width:30px">
                                                @endif
                                            </td >
                                            <td style="width:10%" class="text-center">
                                                <small>{{ isset($match->goalA)?$match->goalA:"..." }}</small>
                                                -
                                                <small>{{ isset($match->goalB)?$match->goalB:"..." }}</small>
                                            </td>
                                            <td style="width:25%">
                                                @if (isset($clubs->where('id', $match->clubB_id)->first()->logo))
                                                    <img src="{{ asset('storage/club-logos/').'/'.$clubs->where('id', $match->clubB_id)->first()->logo }}" alt="" class="img-circle" style="width:30px">
                                                @else 
                                                    <img src="{{ asset('storage/club-logos/logo_default.jpg') }}" alt="" class="img-circle" style="width:30px">
                                                @endif
                                                <small>{{ $clubs->where('id', $match->clubB_id)->first()->name }}</small>
                                            </td>
                                            <td style="width:20%" class="text-right">
                                                <small>{{ isset($match->time)?$match->time:"--:-- --"}}</small>
                                                <small>{{ isset($match->date)?$match->date:"--/--/----" }}</small>
                                            </td>
                                        </tr>
                                    @php $index++ @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                @endfor
            </div>
            <div class="modals">
                <!-- Player Edit Modal -->
                <div class="modal fade" id="showMacthDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title text-center" id="myModalLabel">Chi tiết trận đấu</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row header">
                                    <div class="col-md-6">
                                        <span class="glyphicon glyphicon-time"></span>
                                        <small id="time">Giờ</small>
                                        <small id="date">Ngày</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="glyphicon glyphicon-map-marker"></span>
                                        <small id="address">Địa điểm</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div id="clubA-logo">logo</div>
                                        <p id="clubA-name">Đội A</p>
                                    </div>
                                    <div class="col-md-4 text-center" id="goal">
                                        <small id="goalA">...</small>
                                        -
                                        <small id="goalB">...</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div id="clubB-logo">logo</div>
                                        <p id="clubB-name">Đội B</p>
                                    </div>
                                </div>
                                <div class="row text-center" id="input-result">
                                    <input type="hidden" id="match-id">
                                    <div id="tab1">
                                        <ul class="tab1">
                                            <li><a href="#result">Kết quả</a></li>
                                            <li><a href="#yellow-list">Thẻ vàng</a></li>
                                            <li><a href="#red-list">Thẻ đỏ</a></li>
                                        </ul>
                                    </div>
                                    <div id="tab-content">
                                        <div id="result" class="tab1-item">
                                            <div class="text-center col-md-12">
                                                <p>Tỷ số</p>
                                                <div class="col-md-6 goal">
                                                    <input type="number" id="input-goalA" min="0" class="a-goal pull-right form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6 goal">
                                                    <input type="number" id="input-goalB" min="0" class="b-goal pull-left  form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6" id="add-goal-a"></div>
                                                <div class="col-md-6" id="add-goal-b"></div>
                                            </div>
                                        </div>
                                        <div id="yellow-list" class="tab1-item">
                                            <div class="text-center col-md-12">
                                                <p>Thẻ vàng</p>
                                                <div class="col-md-6">
                                                    <input type="number" id="input-yellowA" min="0" class="pull-right form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" id="input-yellowB" min="0" class="pull-left  form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6" id="add-yellow-a"></div>
                                                <div class="col-md-6" id="add-yellow-b"></div>
                                            </div>
                                        </div>
                                        <div id="red-list" class="tab1-item">
                                            <div class="text-center col-md-12">
                                                <p>Thẻ đỏ</p>
                                                <div class="col-md-6">
                                                    <input type="number" id="input-redA" min="0" class="pull-right form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" id="input-redB" min="0" class="pull-left  form-control" style="width:30%!important">
                                                </div>
                                                <div class="col-md-6" id="add-red-a"></div>
                                                <div class="col-md-6" id="add-red-b"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" id="footer-submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="tournament-slug" value="{{ $tournament->slug }}">
            <input type="hidden" id="tournament-owner" value="{{ $tournament->owner_id }}">
            <input type="hidden" id="user-id" value="{{ isset(Auth::user()->id)?Auth::user()->id:0 }}">
        </div>
        @endif
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">
        // Chi tiết trận đấu
        $('tr.show-detail').each(function(index, element){
            var matchID = $(this).data('match-id');
            $(document).on('click', '.show-detail-'+matchID, function(){
                $('#showMacthDetail').modal('show');
                // Lấy thông tin
                $('#time').html($(this).data('time')?$(this).data('time'):"Chưa cập nhật");
                $('#date').html($(this).data('date')?$(this).data('date'):"Chưa cập nhật");
                $('#address').html($(this).data('address')?$(this).data('address'):"Chưa cập nhật");
                $('#clubA-name').html($(this).data('a-name')?$(this).data('a-name'):"Đội A");
                $('#clubB-name').html($(this).data('b-name')?$(this).data('b-name'):"Đội B");
                $('#goalA').html($(this).data('a-goal')!==""?$(this).data('a-goal'):"...");
                $('#goalB').html($(this).data('b-goal')!==""?$(this).data('b-goal'):"...");
                $('#match-id').val();
                // lấy logo 
                var logoA_name= $(this).data('a-logo');
                var logoB_name = $(this).data('b-logo');
                logoA = logoA_name!=""?'<img src="{{ asset("storage/club-logos/")."/".':logoA_name'}}"/>'.replace(':logoA_name', logoA_name):'<img src="{{ asset("storage/club-logos/logo_default.jpg") }}"/>';
                logoB = logoB_name!=""?'<img src="{{ asset("storage/club-logos/")."/".':logoB_name'}}"/>'.replace(':logoB_name', logoB_name):'<img src="{{ asset("storage/club-logos/logo_default.jpg") }}"/>';
                $('#clubA-logo').html(logoA);
                $('#clubB-logo').html(logoB);
                
                // Tab
                function activeTab(obj)
                {
                    $('#tab1 ul li').removeClass('active');
                    $(obj).addClass('active');
                    var id = $(obj).find('a').attr('href');
                    $('.tab1-item').hide();
                    $(id).show();
                }
                $('.tab1 li').click(function(){
                    activeTab(this);
                    return false;
                });
                activeTab($('.tab1 li:first-child'));

                /*--------------------------------------*/ 
                /* Thêm bàn thắng và cập nhật bàn thắng */ 
                /*--------------------------------------*/ 
                    // Hiển thị tỷ số:
                    $('#input-goalA').val($(this).data('a-goal'));
                    $('#input-goalB').val($(this).data('b-goal'));
                    
                    // Thêm và xóa bàn thắng
                    var add_item_a = '<a class="dynamic item-add-goal-a-'+matchID+' pull-right"><span class="fa fa-plus-circle"></span></a>';
                    var add_item_b = '<a class="dynamic item-add-goal-b-'+matchID+' pull-left"><span class="fa fa-plus-circle"></span></a>';
                    $('div#add-goal-a').html(add_item_a);
                    $('div#add-goal-b').html(add_item_b);
                    var add_goal_a = '<div class="more-goal more-goal-a-'+matchID+'">'+
                                            '<table cellspacing="0" cellpadding="0" id="more-goal">'+
                                                '<tr>'+
                                                    '<td><small>OG</small><input type="checkbox" id="goal-a-isog"></td>'+
                                                    '<td><input type="text" id="goal-a-player-id" class="form-control" list="players-a-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                    '<td style="width:30%"><input type="number" id="goal-a-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                    '<td><a class="dynamic item-remove-goal-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>';
                    var add_goal_b = '<div class="more-goal more-goal-b-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-goal">'+
                                            '<tr>'+
                                                '<td><a class="dynamic item-remove-goal-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '<td style="width:30%"><input type="number" id="goal-b-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                '<td><input type="text" id="goal-b-player-id" class="form-control" list="players-b-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                '<td><small>OG</small><input type="checkbox" id="goal-b-isog"></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                    $('.item-add-goal-a-'+matchID).on('click', function(){
                        $(this).before(add_goal_a);
                    });
                    $('.item-add-goal-b-'+matchID).on('click', function(e){
                        e.preventDefault();
                        $(this).before(add_goal_b);
                    });
                    $(document).on('click', '.item-remove-goal-a-'+matchID, function(){
                        $(this).parents('.more-goal-a-'+matchID).remove();
                    });
                    $(document).on('click', '.item-remove-goal-b-'+matchID, function(e){
                        $(this).parents('.more-goal-b-'+matchID).remove();
                    });
                    
                    // Hiển thị danh sách cầu thủ đã ghi bàn
                    var list_goal_a = $(this).data('list-goal-a');
                    var list_goal_b = $(this).data('list-goal-b');
                    // console.log(list_goal_a);
                    list_goal_a.forEach(function(item){
                        goalId = item['id'];
                        goalMatchId = item['match_id'];
                        goalPlayerId = item['player_id'];
                        goalTime = item['goal_time'];
                        goalIsOg = item['isowngoal'];
                        var goal_a = '<div class="more-goal more-goal-a-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-goal">'+
                                            '<tr>'+
                                                '<td><small>OG</small><input type="checkbox" id="goal-a-isog" class="goal-'+goalId+'"></td>'+
                                                '<td><input type="text" id="goal-a-player-id" class="form-control goal-'+goalId+'" list="players-a-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                                '<td style="width:30%"><input type="number" id="goal-a-time" min="1" class="form-control" value="'+goalTime+'" placeholder="phút thứ..."></td>'+
                                                '<td><a class="dynamic item-remove-goal-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-goal-a-'+matchID).before(goal_a);
                        // checkbox
                        if(goalIsOg == 1){
                            $('#goal-a-isog.goal-'+goalId).prop( "checked", true );
                        }else{
                            $('#goal-a-isog.goal-'+goalId).prop( "checked", false );
                        }
                        // tên cầu thủ
                        $('#goal-a-player-id.goal-'+goalId).val($('#players-a-'+matchID+' option[data-id="'+ goalPlayerId+'"]').val());
                    });
                    list_goal_b.forEach(function(item){
                        goalId = item['id'];
                        goalMatchId = item['match_id'];
                        goalPlayerId = item['player_id'];
                        goalTime = item['goal_time'];
                        goalIsOg = item['isowngoal'];
                        
                        var goal_b = '<div class="more-goal more-goal-b-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-goal">'+
                                            '<tr>'+
                                                '<td><a class="dynamic item-remove-goal-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '<td style="width:30%"><input type="number" id="goal-b-time"class="form-control goal-'+goalId+'" value="'+goalTime+'" placeholder="phút thứ..." ></td>'+
                                                '<td><input type="text" id="goal-b-player-id" min="1" class="form-control goal-'+goalId+'" list="players-b-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                                '<td><small>OG</small><input type="checkbox" id="goal-b-isog" class="goal-'+goalId+'"></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-goal-b-'+matchID).before(goal_b);
                        // checkbox
                        if(goalIsOg == 1){
                            $('#goal-b-isog.goal-'+goalId).prop( "checked", true );
                        }else{
                            $('#goal-b-isog.goal-'+goalId).prop( "checked", false );
                        }
                        // tên cầu thủ
                        $('#goal-b-player-id.goal-'+goalId).val($('#players-b-'+matchID+' option[data-id="'+ goalPlayerId+'"]').val());
                    });
                /*--------------------------------------*/ 
                /* Thêm và cập nhật thẻ vàng */ 
                /*--------------------------------------*/ 
                    // Hiển thị số lượng thẻ
                    $('#input-yellowA').val($(this).data('a-yellow'));
                    $('#input-yellowB').val($(this).data('b-yellow'));
                    // Thêm và xóa thẻ
                    var item_add_yellow_a = '<a class="dynamic item-add-yellow-a-'+matchID+' pull-right"><span class="fa fa-plus-circle"></span></a>';
                    var item_add_yellow_b = '<a class="dynamic item-add-yellow-b-'+matchID+' pull-left"><span class="fa fa-plus-circle"></span></a>';
                    $('#add-yellow-a').html(item_add_yellow_a);
                    $('#add-yellow-b').html(item_add_yellow_b);

                    var add_yellow_a = '<div class="more-yellow more-yellow-a-'+matchID+'">'+
                                            '<table cellspacing="0" cellpadding="0" id="more-yellow">'+
                                                '<tr>'+
                                                    '<td><input type="text" id="yellow-a-player-id" class="form-control" list="players-a-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                    '<td style="width:30%"><input type="number" id="yellow-a-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                    '<td><a class="dynamic item-remove-yellow-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>';
                    var add_yellow_b = '<div class="more-yellow more-yellow-b-'+matchID+'">'+
                                            '<table cellspacing="0" cellpadding="0" id="more-yellow">'+
                                                '<tr>'+
                                                    '<td><a class="dynamic item-remove-yellow-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                    '<td style="width:30%"><input type="number" id="yellow-b-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                    '<td><input type="text" id="yellow-b-player-id" class="form-control" list="players-b-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>';
                    $('.item-add-yellow-a-'+matchID).on('click', function(){
                        $(this).before(add_yellow_a);
                    });
                    $('.item-add-yellow-b-'+matchID).on('click', function(e){
                        e.preventDefault();
                        $(this).before(add_yellow_b);
                    });
                    $(document).on('click', '.item-remove-yellow-a-'+matchID, function(){
                        $(this).parents('.more-yellow-a-'+matchID).remove();
                    });
                    $(document).on('click', '.item-remove-yellow-b-'+matchID, function(e){
                        $(this).parents('.more-yellow-b-'+matchID).remove();
                    });

                    // Hiển thị cầu thủ đã nhận thẻ vàng trước đó
                    var list_yellow_a = $(this).data('list-yellow-a');
                    var list_yellow_b = $(this).data('list-yellow-b');
                    // console.log(list_yellow_a);
                    list_yellow_a.forEach(function(item){
                        yellowId = item['id'];
                        yellowPlayerId = item['player_id'];
                        yellowTime = item['card_time'];
                        var yellow_a = '<div class="more-yellow more-yellow-a-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-yellow">'+
                                            '<tr>'+
                                                '<td><input type="text" id="yellow-a-player-id" class="form-control yellow-'+yellowId+'" list="players-a-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                                '<td style="width:30%"><input type="number" id="yellow-a-time" min="1" max="90" class="form-control" value="'+yellowTime+'" placeholder="phút thứ..."></td>'+
                                                '<td><a class="dynamic item-remove-yellow-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-yellow-a-'+matchID).before(yellow_a);
                        
                        // tên cầu thủ
                        $('#yellow-a-player-id.yellow-'+yellowId).val($('#players-a-'+matchID+' option[data-id="'+ yellowPlayerId+'"]').val());
                    });
                    list_yellow_b.forEach(function(item){
                        yellowId = item['id'];
                        yellowPlayerId = item['player_id'];
                        yellowTime = item['card_time'];
                        
                        var yellow_b = '<div class="more-yellow more-yellow-b-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-yellow">'+
                                            '<tr>'+
                                                '<td><a class="dynamic item-remove-yellow-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '<td style="width:30%"><input type="number" id="yellow-b-time" min="1" max="90" class="form-control yellow-'+yellowId+'" value="'+yellowTime+'" placeholder="phút thứ..." ></td>'+
                                                '<td><input type="text" id="yellow-b-player-id" class="form-control yellow-'+yellowId+'" list="players-b-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-yellow-b-'+matchID).before(yellow_b);
                        // tên cầu thủ
                        $('#yellow-b-player-id.yellow-'+yellowId).val($('#players-b-'+matchID+' option[data-id="'+ yellowPlayerId+'"]').val());
                    });
                /*--------------------------------------*/ 
                /* Thêm và cập nhật thẻ đỏ */ 
                /*--------------------------------------*/ 
                    // Hiển thị số lượng thẻ
                    $('#input-redA').val($(this).data('a-red'));
                    $('#input-redB').val($(this).data('b-red'));
                    // Thêm và xóa thẻ
                    var item_add_red_a = '<a class="dynamic item-add-red-a-'+matchID+' pull-right"><span class="fa fa-plus-circle"></span></a>';
                    var item_add_red_b = '<a class="dynamic item-add-red-b-'+matchID+' pull-left"><span class="fa fa-plus-circle"></span></a>';
                    $('#add-red-a').html(item_add_red_a);
                    $('#add-red-b').html(item_add_red_b);

                    var add_red_a = '<div class="more-red more-red-a-'+matchID+'">'+
                                            '<table cellspacing="0" cellpadding="0" id="more-red">'+
                                                '<tr>'+
                                                    '<td><input type="text" id="red-a-player-id" class="form-control" list="players-a-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                    '<td style="width:30%"><input type="number" id="red-a-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                    '<td><a class="dynamic item-remove-red-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>';
                    var add_red_b = '<div class="more-red more-red-b-'+matchID+'">'+
                                            '<table cellspacing="0" cellpadding="0" id="more-red">'+
                                                '<tr>'+
                                                    '<td><a class="dynamic item-remove-red-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                    '<td style="width:30%"><input type="number" id="red-b-time" min="1" class="form-control" placeholder="phút thứ..."></td>'+
                                                    '<td><input type="text" id="red-b-player-id" class="form-control" list="players-b-'+matchID+'" placeholder="Tên cầu thủ"></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>';
                    $('.item-add-red-a-'+matchID).on('click', function(){
                        $(this).before(add_red_a);
                    });
                    $('.item-add-red-b-'+matchID).on('click', function(e){
                        e.preventDefault();
                        $(this).before(add_red_b);
                    });
                    $(document).on('click', '.item-remove-red-a-'+matchID, function(){
                        $(this).parents('.more-red-a-'+matchID).remove();
                    });
                    $(document).on('click', '.item-remove-red-b-'+matchID, function(e){
                        $(this).parents('.more-red-b-'+matchID).remove();
                    });

                    // Hiển thị cầu thủ đã nhận thẻ đỏ trước đó
                    var list_red_a = $(this).data('list-red-a');
                    var list_red_b = $(this).data('list-red-b');
                    // console.log(list_red_a);
                    list_red_a.forEach(function(item){
                        redId = item['id'];
                        redPlayerId = item['player_id'];
                        redTime = item['card_time'];
                        var red_a = '<div class="more-red more-red-a-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-red">'+
                                            '<tr>'+
                                                '<td><input type="text" id="red-a-player-id" class="form-control red-'+redId+'" list="players-a-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                                '<td style="width:30%"><input type="number" id="red-a-time" min="1" max="90" class="form-control" value="'+redTime+'" placeholder="phút thứ..."></td>'+
                                                '<td><a class="dynamic item-remove-red-a-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-red-a-'+matchID).before(red_a);
                        
                        // tên cầu thủ
                        $('#red-a-player-id.red-'+redId).val($('#players-a-'+matchID+' option[data-id="'+ redPlayerId+'"]').val());
                    });
                    list_red_b.forEach(function(item){
                        redId = item['id'];
                        redPlayerId = item['player_id'];
                        redTime = item['card_time'];
                        
                        var red_b = '<div class="more-red more-red-b-'+matchID+'">'+
                                        '<table cellspacing="0" cellpadding="0" id="more-red">'+
                                            '<tr>'+
                                                '<td><a class="dynamic item-remove-red-b-'+matchID+' pull-right"><span class="glyphicon glyphicon-minus"></span></a></td>'+
                                                '<td style="width:30%"><input type="number" id="red-b-time" min="1" max="90" class="form-control red-'+redId+'" value="'+redTime+'" placeholder="phút thứ..." ></td>'+
                                                '<td><input type="text" id="red-b-player-id" class="form-control red-'+redId+'" list="players-b-'+matchID+'" placeholder="Tên cầu thủ" ></td>'+
                                            '</tr>'+
                                        '</table>'+
                                    '</div>';
                        $('.item-add-red-b-'+matchID).before(red_b);
                        // tên cầu thủ
                        $('#red-b-player-id.red-'+redId).val($('#players-b-'+matchID+' option[data-id="'+ redPlayerId+'"]').val());
                    });

                /*--------------------------------------*/ 
                /* Lưu kết quả trận đấu */ 
                /*--------------------------------------*/
                    submit = '<button class="btn btn-success save-match-result-'+ matchID +'" data-dismiss="modal">Lưu</button>'
                    $('#footer-submit').html(submit);
                    var clubA_id = $(this).data('a-id');
                    var clubB_id = $(this).data('b-id');
                    var matchId = matchID;
                    $(document).on('click', '.save-match-result-'+matchID, function(){
                        // Lấy dữ liệu
                        var slug = $('#tournament-slug').val();
                        url = " {{ route('setting.save-match-result', ":slug") }}";
                        url = url.replace(':slug', slug);
                        var goalsOfMatch = [];
                        var goalsOfA = [];
                        var goalsOfB = [];
                        var yellowsOfA =[];
                        var yellowsOfB = [];
                        var redsOfA = [];
                        var redsOfB = [];
                        goalsOfMatch.push({
                            goalA: $('#input-goalA').val(),
                            goalB: $('#input-goalB').val(),
                            yellow_card_A: $('#input-yellowA').val(),
                            yellow_card_B: $('#input-yellowB').val(),
                            red_card_A: $('#input-redA').val(),
                            red_card_B: $('#input-redB').val(),
                        });
                        $('div.more-goal-a-'+matchID).each(function(index, element){
                            goalsOfA.push({
                                matchId:matchId,
                                clubId:clubA_id,
                                playerId: $("#players-a-"+matchID+" option[value='" + $(this).find('input#goal-a-player-id').val() + "']").attr('data-id'),
                                goalTime: $(this).find('input#goal-a-time').val(),
                                isOwnGoal: $(this).find('input#goal-a-isog').is(':checked')?1:0,
                            });
                        });
                        $('div.more-goal-b-'+matchID).each(function(index, element){
                            goalsOfB.push({
                                matchId:matchId,
                                clubId:clubB_id,
                                playerId: $("#players-b-"+matchID+" option[value='" + $(this).find('input#goal-b-player-id').val() + "']").attr('data-id'),
                                goalTime: $(this).find('input#goal-b-time').val(),
                                isOwnGoal: $(this).find('input#goal-b-isog').is(':checked')?1:0,
                            });
                        });
                        $('div.more-yellow-a-'+matchID).each(function(index, element){
                            yellowsOfA.push({
                                matchId:matchId,
                                clubId:clubA_id,
                                playerId: $("#players-a-"+matchID+" option[value='" + $(this).find('input#yellow-a-player-id').val() + "']").attr('data-id'),
                                cardTime: $(this).find('input#yellow-a-time').val(),
                                isRedCard: 0,
                            });
                        });
                        $('div.more-yellow-b-'+matchID).each(function(index, element){
                            yellowsOfB.push({
                                matchId:matchId,
                                clubId:clubB_id,
                                playerId: $("#players-b-"+matchID+" option[value='" + $(this).find('input#yellow-b-player-id').val() + "']").attr('data-id'),
                                cardTime: $(this).find('input#yellow-b-time').val(),
                                isRedCard: 0,
                            });
                        });
                        $('div.more-red-a-'+matchID).each(function(index, element){
                            redsOfA.push({
                                matchId:matchId,
                                clubId:clubA_id,
                                playerId: $("#players-a-"+matchID+" option[value='" + $(this).find('input#red-a-player-id').val() + "']").attr('data-id'),
                                cardTime: $(this).find('input#red-a-time').val(),
                                isRedCard: 1,
                            });
                        });
                        $('div.more-red-b-'+matchID).each(function(index, element){
                            redsOfB.push({
                                matchId:matchId,
                                clubId:clubB_id,
                                playerId: $("#players-b-"+matchID+" option[value='" + $(this).find('input#red-b-player-id').val() + "']").attr('data-id'),
                                cardTime: $(this).find('input#red-b-time').val(),
                                isRedCard: 1,
                            });
                        });
                        console.log(redsOfB);

                        // Lưu dữ liệu
                        $.ajax({
                            type: "POST", 
                            dataType: "json", 
                            url: url,
                            data: {
                                matchId: matchId,
                                goalsOfMatch: goalsOfMatch,
                                goalsOfA: goalsOfA,
                                goalsOfB: goalsOfB,
                                yellowsOfA:yellowsOfA,
                                yellowsOfB:yellowsOfB,
                                redsOfA: redsOfA,
                                redsOfB: redsOfB,
                                _token: '{{csrf_token()}}'
                            },
                            success: function(response) {
                                if (response.status == "success"){
                                    console.log(response);
                                } else {
                                    console.log(response);
                                }
                                location.reload();
                            }
                        });
                    });
                /*--------------------------------------*/ 
                /* Kiểm tra owner */ 
                /*--------------------------------------*/
                    var userId = $('#user-id').val();
                    var owner = $('#tournament-owner').val();
                    if(userId != owner){
                        $('input').attr('readonly', 'readonly');
                        $("input:checkbox").click(function() { return false; });
                        $('span.fa.fa-plus-circle').hide();
                        $('span.glyphicon.glyphicon-minus').hide();
                        $('#footer-submit').hide();
                    }
            });
        });
    </script>
@endsection

