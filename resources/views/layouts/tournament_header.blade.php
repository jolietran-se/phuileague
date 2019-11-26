<div id="header-information" class="row">
    <div class="col-md-2">
        <div class="header-logo">
            @if(isset($tournament->logo))
                <img class="img-rounded" src="{{ asset('/storage/logos').'/'.$tournament->logo }}" >
            @else
                <img class="img-rounded" src="{{ asset('/storage/logos/avatar_default.jpg') }}">
            @endif
        </div>
    </div>
    <div class="col-md-10">
        <div class="header-detail">
            <!-- Tên giải đấu -->
            <h5><strong>{{ $tournament->name }} </strong></h5>
            <!-- Thông tin tổng quát-->
            <span class="glyphicon glyphicon-menu-hamburger"></span> 
            <small class="header-text">
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
            </small>
            <small class="header-text">Bóng đá sân {{ $tournament->number_player }} | </small>
            <small class="header-text">{{ $tournament->stadium }} |</small>
            <small class="header-text">{{ $tournament->address }}</small>
            <br>
            <small class="header-text"><span class="glyphicon glyphicon-ok-sign"></span> {{ $tournament->number_club }} đội bóng</small>
            <br>

            <!-- Trạng thái giải đấu-->
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