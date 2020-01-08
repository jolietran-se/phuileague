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
                        <li><a href="{{ route('tournament.setting', $tournament->slug)}}">Thông tin chung<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.groupstage', $tournament->slug)}}">Sắp xếp bảng đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li class="active"><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                    </ul>
                </div>
            </div>
            <div id="content" class="col-md-8">
                <div class="page-header profile-text text-center">
                    <h6><strong>Danh sách chính thức</strong></h6>
                    <small>Số lượng: {{ count($clubs) }}</small>
                </div>
                <!-- Danh sách đăng ký -->
                <div id="list-register">
                    <table class="table table-hover" id="table-status">
                        <tr class="gradient">
                            <td>STT</td>
                            <td>Tên đội</td>
                            <td>Người đại diện</td>
                            <td>SĐT Liên hệ</td>
                            <td style="width:10%; overflow:hidden;">Email</td>
                        </tr>
                        <?php $count = 1; ?>
                        @foreach ($clubs as $club)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td><a href="{{ route('club.profile', $club->slug) }}">{{ $club->name }}</a></td>
                                <td><small>{{ isset($club->user->username)?$club->user->username:"Chưa cập nhật" }}</small></td>
                                <td><small>{{ isset($club->user->phone)?$club->user->phone:"Chưa cập nhật" }}</small></td>
                                <td><small>{{ isset($club->user->email)?$club->user->email:"Chưa cập nhật" }}</small></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
@endsection

