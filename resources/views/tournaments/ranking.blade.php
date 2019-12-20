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
                        @foreach ($groups as $group)
                            <table class="table table-striped" style="border: 1px solid #326295;">
                                <tr>
                                    <td style="background: #326295; color:#fff" colspan="7">Bảng {{$group->name}}</td>
                                </tr>
                                <tr style="background: #ece1df47;" class="text-center">
                                    <td>STT</td>
                                    <td style="width:30%">Đội bóng</td>
                                    <td>Số trận</td>
                                    <td>T-H-B</td>
                                    <td>Hiệu số</td>
                                    <td>Thẻ vàng/Thẻ đỏ</td>
                                    <td>Điểm</td>
                                </tr>
                                @php $index=1; @endphp
                                @foreach ($groupClubsRanking as $club)
                                    @if ($club['group_id'] == $group->id)
                                    <tr class="text-center">
                                        <td>{{ $index }} @php $index++; @endphp</td>
                                        <td class="text-left">{{ $club['name'] }}</td>
                                        <td>{{ $club['number_match'] }}</td>
                                        <td>{{ $club['number_win'] }}-{{ $club['number_draw'] }}-{{ $club['number_lose'] }}</td>
                                        <td>{{ $club['goal_for'] }}/{{ $club['goal_against'] }} ({{ $club['goal_for']-$club['goal_against'] }})</td>
                                        <td>{{ $club['number_yellow'] }}/{{ $club['number_red'] }}</td>
                                        <td>{{ $club['point'] }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </table>
                        @endforeach
                    </div>
                    <div id="stage-knockout" class="tab-item col-md-12">
                        Vòng loại trực tiếp
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    </script>
@endsection

