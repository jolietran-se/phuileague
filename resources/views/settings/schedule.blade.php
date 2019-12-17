@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


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
                        <li class="active"><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="col-md-9" id="content">
                <div id="schedule">
                    <div class="page-header profile-text text-center">
                        <h6><strong>Quản lý lịch đấu</strong></h6>
                        <p>Bạn có thể quản lý địa điểm, thời gian diễn ra của từng trận đấu</p>
                    </div>
                    <div id="schedule-detail">
                        <div id="tab1" class="col-md-12">
                            <ul class="tab1">
                                <li><a href="#group-match"><h6>Giai đoạn vòng tròn</h6></a></li>
                                <li><a href="#knockout-match"><h6>Giai đoạn trực tiếp</h6></a></li>
                            </ul>
                        </div>
                        <br>
                        <div class="tab1-content">
                            <div id="group-match" class="tab1-item">
                                <div id="tab">
                                    <ul class="tab">
                                        @for ($i=1; $i<=$number_round; $i++)
                                            <li><a href="#round{{$i}}">{{$i}}</a></li>
                                        @endfor
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    @for($i=1; $i<=$number_round; $i++)
                                        <div id="round{{$i}}" class="round-area col-md-12 tab-item">
                                            <div class="col-md-12 round-label"><p class="text-center">Lượt thi đấu thứ {{ $i }}</p></div>
                                            @php $index = 1; @endphp
                                            @foreach ($groups as $group)
                                                @if ($group->number_round >= $i)
                                                    <div id="group-{{ $group->name }}" data-id="{{ $group->id }}" class="col-md-12 group groupRound{{$i}}">
                                                        <div class="group-container">
                                                            <div class="panel-body">
                                                                @foreach ($matchs as $match)
                                                                    @if ($match->round == $i && $match->group_id == $group->id && $match->stage=="G")
                                                                        <div class="col col-md-12 match-detail round{{$i}}" data-status="{{ $match->status }}" data-id="{{ $match->id }}">
                                                                            <div class="col-md-1 stt">
                                                                                <small>#{{$index}}  Bảng {{$group->name}}</small>
                                                                                @php $index++ @endphp
                                                                            </div>
                                                                            <div class="col col-md-2 club-name">
                                                                                @foreach ($clubs as $club)
                                                                                    @if ($club->id == $match->clubA_id)
                                                                                        <small>{{ $club->name }}</small>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="col col-md-2 club-name">
                                                                                @foreach ($clubs as $club)
                                                                                    @if ($club->id == $match->clubB_id)
                                                                                        <small>{{ $club->name }}</small>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group form">
                                                                                <div class="col col-md-2" style="margin-left: 15px">
                                                                                    <input type="text" id="address-{{$match->id}}" value="{{ $match->address}}" placeholder="Sân số..." class="form-control">
                                                                                </div>
                                                                                <div class="col col-md-2">
                                                                                    <input type="text" id="date-{{$match->id}}" value="{{ $match->date}}" name="schedule_date" placeholder="Ngày" class="form-control">
                                                                                </div>
                                                                                <div class="col col-md-2 bootstrap-timepicker timepicker">
                                                                                    <input type="text" id="time-{{$match->id}}" value="{{ $match->time}}" name="schedule_time" placeholder="Giờ" class="form-control  input-small">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div id="notification" class="col-md-12"><!-- Thông báo --></div>
                                            <div class="footer col-md-12">
                                                <input type="hidden" id="tournament-slug" value="{{ $tournament->slug }}">
                                                <input type="submit" value="Lưu" class="btn btn-success save-round saveRound{{$i}}" 
                                                    data-round="{{$i}}"
                                                    >
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div id="knockout-match" class="tab1-item">
                                1/16| 1/8 |Tứ kết | Bán Kết | Chung kết
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/js/bootstrap-timepicker.min.js"></script>

    <script type="text/javascript">
        //Selected đội bóng trong trận đó, trận nào đã có kết quả thì không thể thay đổi
        $('div.match-detail').each(function(index, element){
            var matchStatus = $(this).attr('data-status');
            var matchId = $(this).attr('data-id');
            if(matchStatus == "close"){
                $('select.'+matchId).attr("disabled", true);
            }
            $('select.form-control').each(function(index1,element){
                var clubID =  $(this).attr('data-id');
                $(this).val(clubID);
            });
        });
        // Tab
        $(document).ready(function(){
            function activeTab1(obj)
            {
                $('#tab1 ul li').removeClass('active');
                $(obj).addClass('active');
                var id = $(obj).find('a').attr('href');
                $('.tab1-item').hide();
                $(id).show();
            }
            // Sự kiện click đổi tab
            $('.tab1 li').click(function(){
                activeTab1(this);
                return false;
            });
            // Hàm active tab nào đó
            function activeTab(obj)
            {
                // Xóa class active tất cả các tab
                $('#tab ul li').removeClass('active');
                // Thêm class active vòa tab đang click
                $(obj).addClass('active');
                // Lấy href của tab để show content tương ứng
                var id = $(obj).find('a').attr('href');
                // Ẩn hết nội dung các tab đang hiển thị
                $('.tab-item').hide();
                // Hiển thị nội dung của tab hiện tại
                $(id).show();
            }
            $('.tab li').click(function(){
                activeTab(this);
                return false;
            });
        
            // Active tab đầu tiên khi trang web được chạy
            activeTab1($('.tab1 li:first-child'));
            activeTab($('.tab li:first-child'));
        });

        // Date Time Format
        $(document).ready(function(){
            // Date
            var date_input=$('input[name="schedule_date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                format: 'dd-mm-yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);

            $('input[name="schedule_time"]').timepicker({
                showInputs: false,
                autoclose: true,
            });
        })

        // Lưu thông tin
        $('input.save-round').each(function(index, element){
            var round = $(this).attr('data-round');
            $(document).on('click', '.saveRound'+round, function(e){
                // Lấy dữ liệu từng lượt
                var schedules = [];
                $('div.match-detail.round'+round).each(function(){
                    var matchId = $(this).attr('data-id');
                    var address = $('input#address-'+matchId).val();
                    var date = $('input#date-'+matchId).val();
                    var time = $('input#time-'+matchId).val();
                    console.log(matchId+address+date+time);
                    schedules.push({
                        matchId: matchId,
                        address: address,
                        date: date,
                        time: time,
                    });
                });

                //Lưu thông tin
                var slug = $('#tournament-slug').val();
                url = " {{ route('setting.save-schedule', ":slug") }}";
                url = url.replace(':slug', slug);
                $.ajax({
                    type: "POST", 
                    dataType: "json", 
                    url: url,
                    data: {
                        schedules:schedules,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        if (response.status == "success"){
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                        location.reload();
                    }
                });
            });
        });
    </script>
    <script>
        toastr.options.positionClass = 'toast-top-right';
        @if(Session::has('save_schedule'))
            toastr.success("{{ Session::get('save_schedule') }}");
        @endif
    </script>
@endsection

