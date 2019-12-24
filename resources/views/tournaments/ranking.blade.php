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
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @else 
                        {{-- <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="setting-section setting-main">
        <div class="container" id="content">
            <div id="ranking">
                <div id="tab" class="col-md-12">
                    <ul class="tab text-center">
                        <li><a href="#stage-group">Vòng bảng</a></li>
                        <li><a href="#stage-knockout">Vòng loại trực tiếp</a></li>
                    </ul>
                </div>
                <div id="tab-content" class="col-md-12">
                    <div id="stage-group" class="tab-item col-md-10">
                        <input type="hidden" id="list-group" value="{{ $groups }}">
                        <div class="text-center">
                            @if (isset(Auth::user()->id)?Auth::user()->id:0 === $tournament->owner_id)
                                <p>Hãy chọn ra các đội xuất sắc nhất theo bảng xếp hạng hoặc tiêu chí riêng của bạn để bước vào vòng loại trực tiếp.</p>
                                <p><b>Chú ý:</b> chỉ thay đổi lựa chọn khi vòng loại chưa diễn ra. Nếu tiếp thục thay đổi, tất cả các kết quả của vòng knockout sẽ bị xóa vĩnh viễn. </p>
                            @endif
                        </div>
                        @foreach ($groups as $group)
                            <div id="group" data-id="{{ $group->id }}">
                                <table class="table table-striped" style="border: 1px solid #326295;" id="group-{{ $group->id }}">
                                    <tr>
                                        <td style="background: #326295; color:#fff" colspan="8">Bảng {{$group->name}}</td>
                                    </tr>
                                    <tr style="background: #ece1df47;" class="text-center">
                                        <td>Hạng</td>
                                        <td style="width:30%">Đội bóng</td>
                                        <td>Số trận</td>
                                        <td>T-H-B</td>
                                        <td>Hiệu số</td>
                                        <td>Thẻ vàng/Thẻ đỏ</td>
                                        <td>Điểm</td>
                                        @if (isset(Auth::user()->id)?Auth::user()->id:0 === $tournament->owner_id)
                                            <td>Vào vòng loại?</td>
                                        @endif
                                    </tr>
                                    @php $index=1; @endphp
                                    @foreach ($groupClubsRanking as $club)
                                        @if ($club->group_id == $group->id)
                                        <tr data-id="{{ $club->id }}" class="text-center {{ $group->id }}-club" data-rank="{{$index}}">
                                            <td>{{ $index }} @php $index++; @endphp</td>
                                            <td class="text-left">
                                                @if (isset(($club->club()->get())[0]->logo))
                                                    <img src="{{ asset('storage/club-logos/').'/'.($club->club()->get())[0]->logo }}" alt="" class="img-circle" style="width:30px">
                                                @else 
                                                    <img src="{{ asset('storage/club-logos/logo_default.jpg') }}" alt="" class="img-circle" style="width:30px">
                                                @endif
                                                {{ ($club->club()->get())[0]->name }}
                                            </td>
                                            <td>{{ $club->g_number_match }}</td>
                                            <td>{{ $club->g_number_win }}-{{ $club->g_number_draw }}-{{ $club->g_number_lost }}</td>
                                            <td>{{ $club->g_goal_for }}/{{ $club->g_goal_against }} ({{ $club->g_goal_for - $club->g_goal_against }})</td>
                                            <td>{{ $club->g_number_yellow }}/{{ $club->g_number_red }}</td>
                                            <td>{{ $club->g_point }}</td>
                                            @if (isset(Auth::user()->id)?Auth::user()->id:0 === $tournament->owner_id)
                                                <input type="hidden" id="isnext-{{$club->id}}" value="{{$club->isnext}}">
                                                <td><input type="checkbox" id="checked-{{$club->id}}" class="rank-{{ $index }}"></td>
                                            @endif
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            
                        @endforeach
                        @php
                        @endphp
                        @if ($userID === $tournament->owner_id)
                            <div>
                                <div id="notification"></div>
                                <input type="submit" value="Lưu" class="btn btn-success submit-pass pull-right">
                            </div>
                        @endif
                    </div>
                    <div id="stage-knockout" class="tab-item col-md-10">
                        <div id="stage-knockout">
                            <table class="table table-striped" style="border: 1px solid #326295;">
                                <tr style="background: #326295; color:#fff" class="text-center">
                                    <td>Hạng</td>
                                    <td>Đội bóng</td>
                                    <td>Số trận</td>
                                    <td>T-H-B</td>
                                    <td>Hiệu số</td>
                                    <td>Thẻ vàng/Thẻ đỏ</td>
                                    <td>Điểm</td>
                                </tr>
                                @php $index1=1; @endphp
                                @foreach ($knockoutClubsRanking as $club)
                                    <tr class="text-center">
                                        <td>
                                            @if($index1 == 1)
                                                <b>Quán quân</b>
                                            @elseif($index1==2)
                                                <b>Á Quân</b>
                                            @elseif($index1==3)
                                                <b>Hạng Ba</b>
                                            @else
                                                {{ $index1 }} 
                                            @endif
                                            @php $index1++; @endphp
                                        </td>
                                        <td class="text-left">
                                            @if (isset($club->logo))
                                                <img src="{{ asset('storage/club-logos/').'/'.$club->logo }}" class="img-circle" style="width:30px">
                                            @else 
                                                <img src="{{ asset('storage/club-logos/logo_default.jpg') }}" class="img-circle" style="width:30px">
                                            @endif
                                            {{ $club->name }}
                                        </td>
                                        <td>{{ $club->pivot->k_number_match }}</td>
                                        <td>{{ $club->pivot->k_number_win }}-{{ $club->pivot->k_number_draw }}-{{ $club->pivot->k_number_lost }}</td>
                                        <td>{{ $club->pivot->k_goal_for }}/{{ $club->pivot->k_goal_against }} ({{ $club->pivot->k_goal_for - $club->pivot->k_goal_against }})</td>
                                        <td>{{ $club->pivot->k_number_yellow }}/{{ $club->pivot->k_number_red }}</td>
                                        <td>{{ $club->pivot->k_point }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="tournament-slug" value="{{ $tournament->slug }}">
    <input type="hidden" id="tournament-knockout" value="{{ $tournament->number_knockout }}">

@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script>
        // Tab
        function activeTab(obj)
        {
            $('#tab ul li').removeClass('active');
            $(obj).addClass('active');
            var id = $(obj).find('a').attr('href');
            $('.tab-item').hide();
            $(id).show();
        }
        $('.tab li').click(function(){
            activeTab(this);
            return false;
        });
        activeTab($('.tab li:first-child'));

        //Hiển thị các đội đã vào vòng knockout
        $('div#group').each(function(index, element){
            var groupId = $(this).attr('data-id');
            $('tr.'+groupId+'-club').each(function(index1, element1){
                var clubId = $(this).attr('data-id');
                var isnext = $(this).find('#isnext-'+clubId).val();
                if(isnext == 1){
                    $('#checked-'+clubId).prop( "checked", true );
                }else{
                    $('#checked-'+clubId).prop( "checked", false );
                }
            });
        });

        // Thay đổi các đội vào vòng knockout
        $(document).on('click', '.submit-pass', function(){
            var passClubs = [];
            $('div#group').each(function(index, element){
                var groupId = $(this).attr('data-id');
                $('tr.'+groupId+'-club').each(function(index1, element1){
                    var clubId = $(this).attr('data-id');
                    passClubs.push({
                        clubId: clubId,
                        isNext: $(this).find('#checked-'+clubId).is(':checked')?1:0,
                        rank: $(this).attr('data-rank')
                    })
                });
            });
            // Kiểm tra số lượng đội
            var numberIsNext = 0;
            var numberKnockout = $('#tournament-knockout').val();
            passClubs.forEach(function(item){
                if(item['isNext'] == 1) numberIsNext++;
            });
            if(numberIsNext == numberKnockout){
                // Lưu thay đổi
                var slug = $('#tournament-slug').val();
                url = " {{ route('setting.save-pass-group', ":slug") }}";
                url = url.replace(':slug', slug);
                $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: url,
                    data: {
                        passClubs: passClubs,
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
            }else{
                html = "<div class='alert alert-danger'> <span>Tổng số đội đi tiếp của các bảng phải bằng "+numberKnockout+"</span> <br></div>"
                $('#notification').html(html);
            }
        });
    </script>
@endsection

