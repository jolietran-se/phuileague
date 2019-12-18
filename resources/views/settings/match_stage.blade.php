@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">

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
                        <li class="active"><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="col-md-9" id="content">
                <div id="match-stage" class="group-stage">
                    <div class="page-header profile-text text-center">
                        <h6><strong>Sắp xếp Cặp đấu</strong></h6>
                    </div>
                    <div id="list-match" class="col-md-12">
                        <div id="tab1" class="col-md-12">
                            <ul class="tab1">
                                <li><a href="#group-match"><h6>Giai đoạn vòng tròn</h6></a></li>
                                <li><a href="#knockout-match"><h6>Giai đoạn trực tiếp</h6></a></li>
                            </ul>
                        </div>
                        <br>
                        <div class="tab1-content">
                            <div id="group-match" class="tab1-item">
                                <p class="text-center">
                                    <small>
                                        Các cặp đấu đã được tự động sắp xếp ngẫu nhiên theo từng lượt đấu. 
                                        <br>Đảm bảo mỗi đội chỉ thi đấu một trận trong một lượt thi đấu và không có đội nào gặp đội khác hai lần!
                                    </small><br>
                                    <small><b>Chú ý:</b> Khi có sự thay đổi, hãy <b>Lưu</b> trước khi chuyển tab khác và đảm bảo không lặp cặp đấu.</small>
                                </p>
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
                                            <div class="col-md-12 round-label"><p class="text-center">VÒNG {{ $i }}</p></div>
                                            @php $index = 1; @endphp
                                            @foreach ($groups as $group)
                                                @if ($group->number_round >= $i)
                                                    <div id="group-{{ $group->name }}" data-id="{{ $group->id }}" class="col-md-12 group groupRound{{$i}}">
                                                        <div class="group-container">
                                                            <div class="page-header"><h6>BẢNG {{ $group->name }}</h6> </div>
                                                            <div class="panel-body">
                                                                @foreach ($matchsG as $match)
                                                                    @if ($match->round == $i && $match->group_id == $group->id && $match->stage=="G")
                                                                        <div class="col col-md-12 match-detail round{{$i}}" data-status="{{ $match->status }}" data-id="{{ $match->id }}">
                                                                            <div class="col col-md-2">
                                                                                #{{ $index }} @php $index++ @endphp
                                                                            </div>
                                                                            <div class="col col-md-5">
                                                                                <select id="{{$match->id}}clubAId" class="form-control {{ $match->id }}" data-id="{{ $match->clubA_id }}">
                                                                                    @foreach ($tournament->clubs as $club)
                                                                                        @if ($club->pivot->group_id == $group->id)
                                                                                            <option value="{{ $club->id }}"><small>{{ $club->name }}</small></option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col col-md-5">
                                                                                <select id="{{$match->id}}clubBId" class="form-control {{ $match->id }}" data-id="{{ $match->clubB_id }}">
                                                                                    @foreach ($tournament->clubs as $club)
                                                                                        @if ($club->pivot->group_id == $group->id)
                                                                                            <option value="{{ $club->id }}"><small>{{ $club->name }}</small></option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
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

        // Lưu sắp xếp cặp đấu theo từng round
        $('input.save-round').each(function(index, element){
            var round = $(this).attr('data-round');
            $(document).on('click', '.saveRound'+round, function(e){
                // Lấy dữ liệu từng lượt
                var matchsG = [];
                $('div.match-detail.round'+round).each(function(){
                    var matchId = $(this).attr('data-id');
                    var clubA_id = $('select#'+matchId+'clubAId').val();
                    var clubB_id = $('select#'+matchId+'clubBId').val();
                    // console.log(matchId+clubA_id+clubB_id);
                    matchsG.push({
                        matchId: matchId,
                        clubA_id: clubA_id,
                        clubB_id: clubB_id,
                    });
                });

                // Kiểm tra xem có đội trùng nhau không
                var flag = true;
                var arrId = [];
                matchsG.forEach(function(item){
                    arrId.push(item['clubA_id']);
                    arrId.push(item['clubB_id']);
                    var count1 = arrId.filter(i => i == item['clubA_id']).length;
                    var count2 = arrId.filter(i => i == item['clubB_id']).length;
                    if(count1 >=2 || count2>=2 ) flag = false;
                });

                // Lưu thông tin
                if(flag==true){
                    var slug = $('#tournament-slug').val();
                    url = " {{ route('setting.save-stage', ":slug") }}";
                    url = url.replace(':slug', slug);
                    console.log(matchsG);
                    $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: url,
                        data: {
                            matchsG:matchsG,
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

                }else{
                    html = "<div class='alert alert-danger'> <span>Trong một lượt thi đấu, một đội không thể tham gia hai trận đấu</span> <br></div>"
                    $('#notification').html(html);
                }
            });
        });
    </script>
    <script>
        toastr.options.positionClass = 'toast-top-right';
        @if(Session::has('match_stage'))
            toastr.success("{{ Session::get('match_stage') }}");
        @endif
    </script>
@endsection

