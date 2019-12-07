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
                        @if($tournament->register_permission == "on")
                            <p>Giải đấu cho phép đăng ký đến hết ngày: {{ $tournament->register_date }}</p>
                            <p>Giải đấu yêu cầu số lượng ít nhất là {{ $tournament->number_player }} cầu thủ mỗi đội</p>
                            <input type="submit" class="btn btn-primary" id="start-register" value="Bắt đầu đăng ký">
                        @else 
                            <p>Giải đấu đã hết hạn đăng ký hoặc không nhận đăng ký!</p>
                            <p>( Ban tổ chức sẽ đăng ký cho các đội bóng! )</p>

                            @if($tournament->owner_id == $userID)
                                <input type="submit" class="btn btn-primary" id="start-register" value="Bắt đầu đăng ký">
                            @endif
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
                                @if(count($clubs) != 0)
                                    @foreach ($clubs as $club)
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
                                Bạn không thể thay đổi danh sách đăng ký khi đã <code>Đăng ký</code></small>
                    </div>
                </div>
                <hr>
                <!-- Danh sách đăng ký -->
                <div id="list-register">
                    <h6>Danh sách đội tham gia</h6>
                    <table class="table table-hover" id="table-status">
                        <tr class="gradient">
                            <td>STT</td>
                            <td>Tên đội</td>
                            <td>Người đại diện</td>
                            <td>SĐT Liên hệ</td>
                            <td>Email</td>
                            <td>Thời gian đăng ký</td>
                            <td style="width:15%">Trạng thái</td>
                            @if ($userID!=0)
                                <td style="width:15%">Thao tác</td>
                            @endif
                        </tr>
                        <?php $count = 1; ?>
                        @foreach ($tournament->clubs as $club)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td><a href="{{ route('club.profile', $club->slug) }}">{{ $club->name }}</a></td>
                                <td>{{ isset($club->user->username)?$club->user->username:"Chưa cập nhật" }}</td>
                                <td>{{ isset($club->user->phone)?$club->user->phone:"Chưa cập nhật" }}</td>
                                <td>{{ isset($club->user->email)?$club->user->email:"Chưa cập nhật" }}</td>
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
                                                <a href="#" class="btn btn-success action-allow" role="button"
                                                    data-club-id = "{{ $club->id}}"
                                                    data-tournament-id = "{{ $tournament->id }}"
                                                    data-tournament-slug = "{{ $tournament->slug }}"
                                                    >Chấp nhận</a>
                                            @default
                                        @endswitch
                                    </td>
                                @elseif($userID == $club->owner_id)
                                    @if ($tournament->register_permission == "on")
                                        <td>
                                            <a href="#" class="btn btn-primary cancel-sign-up" role="button"
                                                data-club-id = "{{ $club->id}}"
                                                data-tournament-slug = "{{ $tournament->slug }}"
                                                data-tournament-id = "{{ $tournament->id }}"
                                            >Hủy đăng ký</a>
                                        </td>
                                    @endif
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
                
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
                        console.log(data1)
                        $('#allowModal').modal('hide');
                        var status1 = 'Đã chấp nhận';
                        var action1 = "<a href='#' class='btn btn-default action-reject' role='button'"+
                                            "data-club-id = '{{ $club->id }}'"+
                                            "data-tournament-id = '{{ $tournament->id }}'"+
                                            "data-tournament-slug = '{{ $tournament->slug }}'"+
                                            ">Từ chối</a>";
                        console.log(data1.clubId);
                        console.log('allow:'+action1);
                        $('#club-'+data1.clubId+'-status').html(status1);
                        $('#club-'+data1.clubId+'-action').html(action1);
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
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
                        var status = 'Đã từ chối';
                        var action = "<a href='#' class='btn btn-success action-allow' role='button'"+
                                            "data-club-id = '{{ $club->id }}'"+
                                            "data-tournament-id = '{{ $tournament->id }}'"+
                                            "data-tournament-slug = '{{ $tournament->slug }}'"+
                                            ">Chấp nhận</a>";
                        console.log('reject:'+action);
                        $('#club-'+data.clubId+'-status').html(status);
                        $('#club-'+data.clubId+'-action').html(action);
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        console.log('error');
                    },
                });
            });
        });

        $(document).on('click', '.cancel-sign-up', function(){
            $('#cancleModal').modal('show');
            var clubID = $(this).data('club-id');
            var tournamentID = $(this).data('tournament-id');
            var tournamentSlug = $(this).data('tournament-slug');
        });
    </script>
@endsection

