@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
@endsection

@section('content')
    <div class="header-tournament">
        <div class="container">
            <!-- Tournament Information Title-->
            @include('layouts.tournament')
            <!-- Header TabList -->
            <div id="tablist-header" class="tablist">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="{{ route('tournament.setting', $tournament->slug)}}">Tùy chỉnh</a></li>
                    <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                    <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                    <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                    <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                    <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                    <li role="presentation" class="active"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                </ul>
            </div>
            <!--================-->
            <!--    CONTENT     -->
            <!--================-->
            <div id="content-about" class="col-md-12">
                <div class="page-header">
                    <h6><strong>Giới thiệu giải</strong></h6>
                </div>
                <div id="introduce">
                    @if(isset($tournament->introduce)) 
                        {{ strip_tags($tournament->introduce) }}
                    @else
                        <p><small>Giải đấu hiện chưa có điều lệ</small></p>
                    @endif
                </div>
                <div class="page-header">
                    <h6>
                        <strong>Điều lệ giải: </strong>
                        @if (isset($tournament->charter))
                            <a href="{{ route('tournament.charter', [ $tournament->slug, $tournament->charter]) }}"  target="_blank"> Tải xuống </a>
                        @endif
                    </h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
@endsection

