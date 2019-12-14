@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">

@endsection

@section('content')
    <div class="header-tournament">
        <div class="container">
            <!-- Tournament Information Title-->
            @include('layouts.tournament')
            <!-- Header TabList -->
            <div id="tablist-header" class="tablist">
                <ul class="nav nav-tabs">
                        @if ($userID == $tournament->owner_id)
                        <li role="presentation"><a href="{{ route('tournament.setting', $tournament->slug)}}">Tùy chỉnh</a></li>
                        <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @else 
                        <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                        <li role="presentation" class="active"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                        <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                        <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                        <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                        <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="setting-section setting-main">
        <div class="container" id="content">
            <div class="col-md-12 content">
                <div id="register">
                    <h6>Đăng ký thi đấu: ({{ $tournament->register_permission }})</h6>
                    <div class="gradient text-center register">
                        {{-- {{ $tournament->status}} --}}
                        @if($tournament->register_permission == "on" && $tournament->status != 4)
                            <p>Giải đấu cho phép đăng ký đến hết ngày: {{ $tournament->register_date }}</p>
                            <p>Giải đấu yêu cầu số lượng từ {{ $tournament->number_player }} cầu thủ {{ isset($tournament->max_player)?", tối đa $tournament->max_player cầu thủ":"" }} mỗi đội</p>
                            <input type="submit" class="btn btn-primary" id="start-register" value="Bắt đầu đăng ký">
                        @elseif ($tournament->register_permission == "off" && $tournament->status != 4)
                            <p>Giải đấu đã hết hạn đăng ký hoặc không nhận đăng ký!</p>
                            <p>( Ban tổ chức sẽ đăng ký cho các đội bóng! )</p>

                            @if($tournament->owner_id == $userID)
                                <input type="submit" class="btn btn-primary" id="start-register" value="Bắt đầu đăng ký">
                            @endif
                        @else
                            <p>Giải đấu đã kết thúc đăng ký!</p>
                            <a href="{{ route('tournament.listclub', $tournament->slug) }}" class="btn btn-primary">Danh sách chính thức</a>
                        @endif
                    </div>
                    <!-- Form Đăng ký -->
                    <div id="register-form" class="register">
                        <h6>Lựa chọn đội tham gia</h6>
                        <small>
                            <small>Lựa chọn đội bóng mà bạn quản lý sẽ tham dự giải đấu.</small><br>
                            <small>Nếu bạn chưa có đội bóng nào trên hệ thống thì bạn nhấn vào <code>Tạo đội</code> rồi điền đầy đủ thông tin.</small><br>
                            <small>Sau khi đã có đội bóng nhấn vào nút <code>Đăng ký</code> để hoàn tất đăng ký</small>
                        </small>
                        <form action="{{ route('tournament.register', $tournament->slug) }}" method="post">
                            @csrf
                            <select name="club_id" id="club_id" class="form-control">
                                <option value="">-------------Lựa chọn----------</option>
                                @if(count($userClubs) != 0)
                                    @foreach ($userClubs as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                            @if ($errors->has('club_id'))
                                <p class="error-danger">{{ $errors->first('club_id') }}</p>
                            @endif

                            <input type="submit" class="btn btn-primary" value="Đăng ký" style="margin-top: 10px">
                        </form>

                        <small>Lưu ý: Các cầu thủ trong <code>Đội hình thi đấu</code> sẽ có mặt trong danh sách đăng ký. 
                                Bạn không thể thay đổi danh sách đăng ký khi đã được <code>chấp nhận</code></small>
                    </div>
                </div>
                <hr>
                <!-- Danh sách đăng ký -->
                <div id="list-register">
                    <h6>Danh sách đăng ký tham gia: 
                        <span class="label label-default" style="float:right; margin-right: 5px">Đã từ chối: {{ $number_reject }}</span>
                        <span class="label label-success" style="float:right; margin-right: 5px">Đã chấp nhận: {{ $number_allow }}</span>
                        <span class="label label-info" style="float:right; margin-right: 5px">Đang xét: {{ $number_consider}}</span>
                    </h6>
                    <table class="table table-hover" id="table-status">
                        <tr class="gradient">
                            <td>STT</td>
                            <td>Tên đội</td>
                            <td>Người đại diện</td>
                            <td>SĐT Liên hệ</td>
                            <td style="width:10%; overflow:hidden;">Email</td>
                            <td>Thời gian đăng ký</td>
                            <td style="width:15%">Trạng thái</td>
                            @if ($userID != 0 && $tournament->status != "4")
                                <td style="width:15%" id="action-column">Thao tác</td>
                            @endif
                        </tr>
                        <?php $count = 1; ?>
                        @foreach ($tournament->clubs as $club)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td><a href="{{ route('club.profile', $club->slug) }}">{{ $club->name }}</a></td>
                                <td><small>{{ isset($club->user->username)?$club->user->username:"Chưa cập nhật" }}</small></td>
                                <td><small>{{ isset($club->user->phone)?$club->user->phone:"Chưa cập nhật" }}</small></td>
                                <td><small>{{ isset($club->user->email)?$club->user->email:"Chưa cập nhật" }}</small></td>
                                <td>{{ $club->pivot->created_at }}</td>
                                <td id="club-{{$club->id}}-status">
                                    @switch($club->pivot->status)
                                        @case(0)
                                            Đang xét
                                            @break
                                        @case(1)
                                            Đã chấp nhận
                                            @break
                                        @case(2)
                                            Đã từ chối
                                            @break
                                        @default
                                    @endswitch
                                </td>
                                @if ($tournament->status != "4")
                                    @if($userID == $tournament->owner_id)
                                        <td id="club-{{$club->id}}-action">
                                            @switch($club->pivot->status)
                                                @case(0)
                                                    <a href="#" class="btn btn-success action-allow" role="button"
                                                        data-club-id = "{{ $club->id }}"
                                                        data-tournament-id = "{{ $tournament->id }}"
                                                        data-tournament-slug = "{{ $tournament->slug }}"
                                                    >Chấp nhận
                                                    </a>
                                                    <a href="#" class="btn btn-default action-reject" role="button"
                                                        data-club-id = "{{ $club->id}}"
                                                        data-tournament-id = "{{ $tournament->id }}"
                                                        data-tournament-slug = "{{ $tournament->slug }}"
                                                        >Từ chối </a>
                                                    @break
                                                @case(1)
                                                    <a href="#" class="btn btn-default action-reject" role="button"
                                                        id="{{ $club->id }}"
                                                        data-club-id = "{{ $club->id }}"
                                                        data-tournament-id = "{{ $tournament->id }}"
                                                        data-tournament-slug = "{{ $tournament->slug }}"
                                                        >Từ chối</a>
                                                    @break
                                                @case(2)
                                                    <!-- Đã từ chối thì không thể thao tác thêm -->
                                                    <a href="#" class="btn btn-success action-allow" role="button"
                                                        data-club-id = "{{ $club->id }}"
                                                        data-tournament-id = "{{ $tournament->id }}"
                                                        data-tournament-slug = "{{ $tournament->slug }}"
                                                    >Chấp nhận
                                                    </a>
                                                @default
                                            @endswitch
                                        </td>
                                    @elseif($userID == $club->owner_id)
                                        @if ($tournament->register_permission == "on")
                                            <td id="cancle-column">
                                                <a href="#" class="btn btn-primary cancel-sign-up" role="button"
                                                    data-club-id = "{{ $club->id}}"
                                                    data-club-slug = "{{ $club->slug }}"
                                                    data-tournament-id = "{{ $tournament->id }}"
                                                >Hủy đăng ký</a>
                                            </td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                                
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- Kết thúc đăng ký -->
                @if($userID == $tournament->owner_id && $tournament->status != 4)
                    <input type="submit" value="Kết thúc đăng ký" class="btn btn-primary sign-up-modal" style="margin-left: 42%">
                @endif
                <!-- Modal thay đổi trạng thái -->
                <div id="modals">
                    <!-- Allow Modal -->
                    <div class="modal fade" id="allowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title" id="myModalLabel">Chấp nhận</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn đã xem hồ sơ và quyết định <b>ĐỒNG Ý</b> cho đội bóng này tham gia giải đấu?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger allow-club">Đồng ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title" id="myModalLabel">Từ chối</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn đã xem hồ sơ và quyết định <b>TỪ CHỐI</b> đội bóng này tham gia giải đấu?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger reject-club">Từ chối</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hủy Đăng Ký Modal -->
                    <div class="modal fade" id="cancleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title" id="myModalLabel">Hủy đăng ký</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn chắc chắn muốn rút khỏi giải đấu này?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger cancel-sign-up">Chắc chắn</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal kết thúc đăng ký-->
                <div class="modal fade" id="endModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="myModalLabel">Kết thúc đăng ký</h5>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="tournament-slug" value="{{ $tournament->slug }}">
                                <p><span class="glyphicon glyphicon-share-alt"></span> Khi bạn kết thúc đăng ký, giải đấu sẽ chuyển sang trạng thái <span class="label label-primary">Hoạt động</span></p>
                                <p><span class="glyphicon glyphicon-share-alt"></span> Bạn không thể chỉnh sửa danh sách đăng ký, các đội bóng đã được chấp nhận sẽ nằm trong danh sách chính thức của giải đấu.</p>
                                <p><span class="glyphicon glyphicon-share-alt"></span> Chọn <code>Tùy chỉnh</code> để tiếp tục quản lý giải đấu</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger end-sign-up">Đồng ý</button>
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
    
    <!-- Show form đăng ký -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#register-form").hide();
        $("#start-register").click(function () {
            $("#register-form").slideToggle();
        });
    </script>
    <!-- Notification-->
    <script>
        toastr.options.positionClass = 'toast-bottom-right';
        @if(Session::has('register_success'))
            toastr.success("{{ Session::get('register_success') }}");
        @endif
        @if(Session::has('register_fail'))
            toastr.warning("{{ Session::get('register_fail') }}");
        @endif
        @if(Session::has('end-sign-up'))
            toastr.info("{{ Session::get('end-sign-up') }}");
        @endif
    </script>
    <!-- Thay đổi trạng thái-->
    <script type="text/javascript">
        $(document).on('click', '.action-allow', function(e){
            e.preventDefault();
            $('#allowModal').modal('show');
            var clubID = $(this).data('club-id');
            var tournamentID = $(this).data('tournament-id');
            var tournamentSlug = $(this).data('tournament-slug');
            $(document).on('click', '.allow-club', function(){
                url = "{{ route('tournament.action-allow', ":slug") }}"
                url = url.replace(':slug', tournamentSlug);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: url,
                    data:{
                        'clubID': clubID,
                        'tournamentID': tournamentID,
                    }, success:function(data1){
                        $('#allowModal').modal('hide');
                        // var status1 = 'Đã chấp nhận';
                        // var action1 = "<a href='#' class='btn btn-default action-reject' role='button'"+
                        //                     "data-club-id = '{{ $club->id }}'"+
                        //                     "data-tournament-id = '{{ $tournament->id }}'"+
                        //                     "data-tournament-slug = '{{ $tournament->slug }}'"+
                        //                     ">Từ chối</a>";
                        // $('#club-'+data1.clubId+'-status').html(status1);
                        // $('#club-'+data1.clubId+'-action').html(action1);
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
                        toastr.info("Đã xảy ra lỗi");
                    },
                });
            });
        });
        
        $(document).on('click', '.action-reject', function(e){
            e.preventDefault();
            $('#rejectModal').modal('show');
            var clubID = $(this).data('club-id');
            var tournamentID = $(this).data('tournament-id');
            var tournamentSlug = $(this).data('tournament-slug');
            $(document).on('click', '.reject-club', function(){
                url = "{{ route('tournament.action-reject', ":slug") }}"
                url = url.replace(':slug', tournamentSlug);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: url,
                    data:{
                        'clubID': clubID,
                        'tournamentID': tournamentID,
                    }, success:function(data){
                        $('#rejectModal').modal('hide');
                        // var status = 'Đã từ chối';
                        // var action = "<a href='#' class='btn btn-success action-allow' role='button'"+
                        //                     "data-club-id = '{{ $club->id }}'"+
                        //                     "data-tournament-id = '{{ $tournament->id }}'"+
                        //                     "data-tournament-slug = '{{ $tournament->slug }}'"+
                        //                     ">Chấp nhận</a>";
                        // $('#club-'+data.clubId+'-status').html(status);
                        // $('#club-'+data.clubId+'-action').html(action);
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
                        toastr.info("Đã xảy ra lỗi");
                    },
                });
            });
        });

        $(document).on('click', '.cancel-sign-up', function(){
            $('#cancleModal').modal('show');
            var clubID = $(this).data('club-id');
            var tournamentID = $(this).data('tournament-id');
            var clubSlug = $(this).data('club-slug');
            console.log(clubSlug);
            $(document).on('click', '.cancel-sign-up', function(){
                url = "{{ route('club.cancel-signup', ":slug") }}"
                url = url.replace(':slug', clubSlug);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: url,
                    data:{
                        'clubID': clubID,
                        'tournamentID': tournamentID,
                    },success:function(data){
                        $('#cancleModal').modal('hide');
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
                        toastr.info("Đã xảy ra lỗi");
                    },
                });
            });
        });
    </script>
    <!-- Kết thúc đăng ký -->
    <script type="text/javascript">
        $(document).on('click', '.sign-up-modal', function(e){
            e.preventDefault();
            $('#endModal').modal('show');
            $(document).on('click', '.end-sign-up', function(e){
                e.preventDefault;
                var slug = $('#tournament-slug').val();
                url = "{{ route('tournament.end-sign-up', ":slug") }}";
                url = url.replace(':slug', slug);
                console.log(url);
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: url,
                    data:{
                        'slug': slug,
                    },success:function(data){
                        $('#endModal').modal('hide');
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
                        toastr.info("Đã xảy ra lỗi");
                    },
                });
            });
        });
    </script>
@endsection

