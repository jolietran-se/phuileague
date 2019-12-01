@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">

@endsection

@section('content')
    <!-- Setting tab list -->
    @include('layouts.setting')

    <div class="setting-section setting-main">
        <div class="container">
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ route('tournament.setting', $tournament->slug)}}">Thông tin chung</a></li>
                        <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái</a></li>
                        <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng</a></li>
                        <li><a href="{{ route('setting.groupstage', $tournament->slug)}}">Sắp xếp bảng đấu</a></li>
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu</a></li>
                        <li class="active"><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu</a></li>
                        <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng</a></li>
                        <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                Lịch đấu
            </div>
        </div>
    </div>
@endsection

@section('foot')
@endsection

