@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="header-profile">
        <div class="container">
            @include('layouts.user_header')
            <div id="tablist">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="{{ route('user.tournaments', $user->username) }}">Quản lý giải đấu</a></li>
                    <li role="presentation" class="active"><a href="{{ route('user.clubs', $user->username) }}">Quản lý đội bóng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="list-section list-main">
        <div class="container">
            Quản lý đội bóng
        </div>
    </div>
@endsection
@section('foot')
@endsection