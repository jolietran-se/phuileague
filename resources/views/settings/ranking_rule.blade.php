@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="header-tournament">
        <div class="container">
            <!-- Tournament Information Title-->
            @include('layouts.tournament_header')
            <!-- Header TabList -->
            <div id="tablist-header" class="tablist">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="{{ route('tournament.setting', $tournament->slug)}}">Tùy chỉnh</a></li>
                    <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                    <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                    <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                    <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                    <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="setting-section setting-main">
        <div class="container">
            <div class="col-md-2">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ route('tournament.setting', $tournament->slug)}}">Thông tin chung</a></li>
                        <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái</a></li>
                        <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng</a></li>
                        <li><a href="{{ route('setting.groupstage', $tournament->slug)}}">Sắp xếp bảng đấu</a></li>
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu</a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu</a></li>
                        <li class="active"><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng</a></li>
                        <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                Quy tắc xếp hạng
            </div>
        </div>
    </div>
@endsection

@section('foot')
@endsection

