@extends('layouts.master')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
@section('head')
    
@endsection

@section('content')
    <!-- Header TabList -->
    <div class="club-section club-main">
        <div class="container">
            <div class="page-header page-title text-center">
                <h5><strong>{{ $club->name }}</strong></h5>
                <small>(Chỉnh sửa thông tin, thêm thành viên và thống kê thành tích)</small>
            </div>
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="{{ route('club.profile', $club->slug)}}">Thông tin chung<span class="glyphicon glyphicon-chevron-right"></span></a></li>
                        <li role="presentation"><a href="{{ route('club.setting', $club->slug)}}">Chỉnh sửa thông tin đội<span class="glyphicon glyphicon-chevron-right"></a></li>
                            <li role="presentation"><a href="{{ route('club.member', $club->slug)}}">Thành viên<span class="glyphicon glyphicon-chevron-right"></a></li>
                        <li role="presentation"><a href="{{ route('club.statistic', $club->slug)}}">Thống kê<span class="glyphicon glyphicon-chevron-right"></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="panel panel-success">
                    <div class="page-header text-center">
                        <h6><strong>Thông tin chung</strong></h6>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-md-4" id="show-logo">
                                <p class="text-center">Logo</p>
                                @if (isset($club->logo))
                                    <img src="{{ asset('/storage/club-logos').'/'.$club->logo }}" alt="">
                                @else
                                    <img src="{{ asset('/storage/club-logos/logo_default.jpg') }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <p>
                                    <span class="glyphicon glyphicon-education"></span>
                                    Trình độ: 
                                    @switch($club->club_type)
                                        @case(1)
                                            Chuyên nghiệp
                                            @break
                                        @case(2)
                                            Bán chuyên nghiệp
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
                                </p><hr>
                                <p>
                                    <span class="glyphicon glyphicon-asterisk"></span>
                                    Giới tính: {{ $club->gender==0?"Nữ":"Nam"}}
                                </p><hr>
                                <p>
                                    <span class="glyphicon glyphicon-king"></span>
                                    Độ tuổi: 
                                    @switch($club->ages)
                                        @case(1)
                                            < 15
                                            @break
                                        @case(2)
                                            15-20
                                            @break
                                        @case(3)
                                            20-25
                                            @break
                                        @case(4)
                                            25-30
                                            @break
                                        @case(5)
                                            > 30
                                            @break
                                        @case(6)
                                            Nhiều độ tuổi
                                            @break
                                        @default
                                            
                                    @endswitch
                                </p><hr>
                                <p>
                                    <span class="glyphicon glyphicon-user"></span>
                                    Số thành viên: {{ isset($club->number_player)?$club->number_player:" Chưa cập nhật" }}
                                </p><hr>
                                <p>
                                    <span class="glyphicon glyphicon-phone"></span>
                                    Số điện thoại: {{ isset($club->phone)?$club->phone:" Chưa cập nhật" }}
                                </p><hr>
                                <p>
                                    <span class="glyphicon glyphicon-envelope"></span>
                                    Email: {{ isset($club->email)?$club->email:" Chưa cập nhật" }}
                                </p><hr>
                            </div>
                            
                        </div>
                        <div class="col-md-4" id="show-uniform">
                            <p class="text-center">Đồng phục</p>
                            @if (isset($club->uniform))
                                <img src="{{ asset('/storage/club-uniforms').'/'.$club->uniform }}" alt="">
                            @else
                                <img src="{{ asset('/storage/club-uniforms/uniform_default.png') }}">
                            @endif
                            
                        </div>
                        <div class="col-md-8" style="padding-left: 22px">
                            <p>
                                <span class="glyphicon glyphicon-tags"></span> 
                                Giới thiệu: <?php echo isset($club->description)?$club->description:"Chưa cập nhật" ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
   
@endsection