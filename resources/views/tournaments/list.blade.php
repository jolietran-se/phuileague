@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="header-tournament search-tournament">
        <div class="container">
            <div id="header-information" class="row">
                <form action="{{ route('tournament.search') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-sm-4 col-xs-10">
                        <div class="input-group">
                            <input class="form-control" type="text" name="search" id="search" placeholder="Tìm kiếm">
                            <div class="input-group-addon">
                                <input type="submit" class="btn btn-primary search-tournament" style="margin:-7px; padding: 5px 10px 5px 10px" value="Tìm">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-8 col-xs-12">
                        <div class="col-sm-3 filter-type">
                            <select class="form-control" name="tournamentType" id="tournamentType">
                                <option value="">Hình thức</option>
                                <option value="1">Loại trực tiếp</option>
                                <option value="2">Đấu vòng tròn</option>
                                <option value="3">Hai giai đoạn</option>
                            </select>
                        </div>
                        <div class="col-sm-2 filter-status">
                            <select class="form-control" name="tournamentStatus" id="tournamentStatus">
                                <option value="">Trạng thái</option>
                                <option value="1">Đóng</option>
                                <option value="2">Chưa kích hoạt</option>
                                <option value="3">Đăng ký</option>
                                <option value="4">Hoạt động</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="sortOption" id="sortOption">
                                <option value="">Sắp xếp</option>    
                                <option value="1">Giải đấu mới</option>
                                <option value="2">Xếp theo tên</option>
                            </select>    
                        </div> 
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
    <div class="tournament-section tournament-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header profile-text">
                        <h4>Danh sách các giải đấu</h4>
                    </div>
                    <div id="list-tournament">
                        @foreach ($tournaments as $tour)
                            <div class="col-sm-3 col-md-3">
                                <div class="thumbnail">
                                    <a href="{{ route('tournament.setting', $tour->slug) }}">
                                        @if(isset($tour->logo))
                                            <img src="{{ asset('storage/logos/').'/'.$tour->logo }}" alt="...">
                                        @else
                                            <img src="{{ asset('/storage/logos/banner_default.png') }}">
                                        @endif
                                    </a>
                                    <div class="caption">
                                        <a href="{{ route('tournament.setting', $tour->slug) }}">
                                            <h6 class="text-center" style="color:#326295">{{ $tour->name }}</h6>
                                        </a>
                                        <p class="text-center author"><small class="header-text">BTC: {{ $tour->user->username }}</small></p>
                                        <p class="text-center"  >
                                            <small class="header-text">
                                                @switch($tour->tournament_type_id)
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
                                                Bóng đá sân {{ $tour->number_player }} 
                                            </small>
                                        </p>
                                        <p class="text-center">
                                            <small class="header-text">{{ isset($tour->stadium)?$tour->stadium:"Chưa cập nhật" }} 
                                            | {{ isset($tour->address)?$tour->address:"Chưa cập nhật" }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!--  Notification with Toastr -->
    <script>
        toastr.options.positionClass = 'toast-top-bottom';
        @if(Session::has('search_false'))
            toastr.info("{{ Session::get('search_false') }}");
        @endif
    </script>
@endsection