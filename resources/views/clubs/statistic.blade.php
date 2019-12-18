@extends('layouts.master')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
@section('head')
    
@endsection

@section('content')
    @php
        $userID = isset(Auth::user()->id)?Auth::user()->id:0;
    @endphp
    <!-- Header TabList -->
    <div class="club-section club-main">
        <div class="container">
            <div class="page-header text-center page-title">
                <h5><strong>{{ $club->name }}</strong></h5>
                <small>(Chỉnh sửa thông tin, thêm thành viên và thống kê thành tích)</small>
            </div>
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a href="{{ route('club.profile', $club->slug)}}">Thông tin chung<span class="glyphicon glyphicon-chevron-right"></a></li>
                        @if ($club->owner_id == $userID)
                            <li role="presentation"><a href="{{ route('club.setting', $club->slug)}}">Chỉnh sửa thông tin đội<span class="glyphicon glyphicon-chevron-right"></a></li>
                        @endif
                        <li role="presentation"><a href="{{ route('club.member', $club->slug)}}">Thành viên<small>({{ isset($club->number_player)?$club->number_player:0 }})</small><span class="glyphicon glyphicon-chevron-right"></a></li>
                        {{-- <li role="presentation" class="active"><a href="{{ route('club.statistic', $club->slug)}}">Thống kê<span class="glyphicon glyphicon-chevron-right"></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('foot')
    <script src="{{ asset('bower_components/Croppie/croppie.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
@endsection