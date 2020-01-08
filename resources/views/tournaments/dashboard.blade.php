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
                        <li role="presentation" class="active"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        {{-- <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @else 
                        <li role="presentation" class="active"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        {{-- <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li> --}}
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @endif
                </ul>
            </div>
        Thông tin chung
    </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script>
        @if(Session::has('check_owner'))
            toastr.info("{{ Session::get('check_owner') }}");
        @endif
    </script>
@endsection

