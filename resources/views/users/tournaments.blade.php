@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
@endsection

@section('content')
    <div class="header-profile">
        <div class="container">
            @include('layouts.user')
            <div id="tablist">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="{{ route('user.tournaments', $user->username) }}">Quản lý giải đấu ({{ count($tournaments) }})</a></li>
                    <li role="presentation"><a href="{{ route('user.clubs', $user->username) }}">Quản lý đội bóng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="list-section list-main">
        <div class="container">
            @foreach ($tournaments as $tournament)
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            @if (isset($tournament->logo))
                                <a href="#"><img class="media-object" src="{{ asset('/storage/logos').'/'.$tournament->logo }}" alt=""></a>
                            @else 
                                <a href="#"><img class="media-object" src="{{ asset('/storage/avatars/avatar_default.jpg') }}" alt=""></a>
                            @endif
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading"><a href="{{ route('tournament.setting', $tournament->slug) }}">{{ $tournament->name }}</a></h5>
                        <div id="media-detail">
                            <small>
                                @switch($tournament->tournament_type_id)
                                    @case(1)
                                        Đấu loại trực tiếp |
                                        @break
                                    @case(2)
                                        Đấu vòng tròn |
                                        @break
                                    @case(3)
                                        Hai giai đoạn |
                                        @break
                                    @default
                                @endswitch
                                {{ $tournament->number_club }} đội bóng | 
                                Bóng đá sân {{ $tournament->number_player }} | 
                                {{ $tournament->stadium }} | 
                                {{ $tournament->address }}
                            </small>
                        </div>
                        <div id="media-status">
                            @switch($tournament->status)
                                @case(1)
                                    <span class="label label-danger">Đóng</span>
                                    @break
                                @case(2)
                                    <span class="label label-default">Chưa kích hoạt</span>
                                    @break
                                @case(3)
                                    <span class="label label-success">Đăng ký</span>
                                    @break
                                @case(4)
                                    <span class="label label-primary">Hoạt động</span>
                                    @break
                                @default
                            @endswitch
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('foot')
@endsection

