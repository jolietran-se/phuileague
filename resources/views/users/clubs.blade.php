@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
@endsection

@section('content')
    <div class="header-profile">
        <div class="container">
            @include('layouts.user')
            <div id="tablist">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="{{ route('user.tournaments', $user->username) }}">Quản lý giải đấu</a></li>
                    <li role="presentation" class="active"><a href="{{ route('user.clubs', $user->username) }}">Quản lý đội bóng ({{count($clubs)}})</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="list-section list-main">
        <div class="container">
            <div class="row">
                @foreach ($clubs as $club)
                    <div class="col-md-2 col-sm-3">
                        <div class="thumbnail">
                            <div id="logo" class="club-logo">
                                <a href="{{ route('club.profile', $club->slug) }}">
                                    @if (isset($club->logo))
                                        <img src="{{ asset('/storage/club-logos').'/'.$club->logo }}" alt=""></a>
                                    @else 
                                        <img src="{{ asset('/storage/club-logos/logo_default.jpg') }}" alt=""></a>
                                    @endif
                                </a>
                            </div>
                            <div class="caption">
                                <a href="{{ route('club.profile', $club->slug) }}" class="media-heading"><h6 class="text-center club-name">{{ $club->name }}</h6></a>
                                <hr>
                                <div id="media-detail">
                                    <small>
                                        <p class="text-center">
                                            @switch($club->gender)
                                                @case(0)
                                                    Nữ |
                                                    @break
                                                @case(1)
                                                    Nam | 
                                                    @break
                                                @default
                                            @endswitch 
                                            @switch($club->ages)
                                                @case(1)
                                                    Độ tuổi < 15
                                                    @break
                                                @case(2)
                                                    Độ tuổi 15-20
                                                    @break
                                                @case(3)
                                                    Độ tuổi 20-25
                                                    @break
                                                @case(4)
                                                    Độ tuổi 25-30
                                                    @break
                                                @case(5)
                                                    Độ tuổi > 30
                                                    @break
                                                @case(6)
                                                    Nhiều độ tuổi
                                                    @break
                                                @default
                                            @endswitch
                                        </p>
                                        <hr>
                                        <p class="text-center">
                                            Trình độ:
                                            @switch($club->club_type)
                                                @case(1)
                                                    CN
                                                    @break
                                                @case(2)
                                                    BCN
                                                    @break
                                                @case(3)
                                                    Phủi
                                                    @break
                                                @case(4)
                                                    Vui
                                                    @break
                                                @case(5)
                                                    Khác
                                                    @break
                                                @default
                                            @endswitch
                                        </p>
                                        <hr>
                                        <p class="text-center"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ isset($club->number_player)?$club->number_player:0 }} thành viên</p>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('foot')
@endsection