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
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu</a></li>
                        {{-- <li class="active"><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                    </ul>
                </div>
            </div>

            <!-- Content Status -->
            <div class="col-md-8" id="status-tournament">
                <div class="page-header profile-text text-center">
                    <h6><strong>Thay đổi trạng thái</strong></h6>
                </div>
                
                <div id="status" class="subcontent">
                    <label>Trạng thái hiện tại:</label>
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
                <hr>
                <div id="change-status" class="subcontent">
                    <label>Thay đổi trạng thái:</label>
                    <form action="" method="post">
                            @switch($tournament->status)
                                @case(1)
                                    {{-- <small>Giải đấu đã được đã được lưu trữ.</small> --}}
                                    <button type="button" class="btn btn-info btn-status" data-toggle="modal" data-target="#satusModal">
                                        Hoạt động
                                    </button>
                                    @break
                                @case(2)
                                    <button type="button" class="btn btn-info btn-status" data-toggle="modal" data-target="#satusModal">
                                        Kích hoạt
                                    </button>
                                    @break
                                @case(3)
                                    <button type="button" class="btn btn-info btn-status" data-toggle="modal" data-target="#satusModal">
                                       Kết thúc đăng ký
                                    </button>
                                    @break
                                @case(4)
                                    <button type="button" class="btn btn-info btn-status" data-toggle="modal" data-target="#satusModal">
                                        Đóng
                                    </button>
                                    @break
                                @default
                            @endswitch
                    </form>
                </div>
                <hr>
                <div class="subcontent">
                    <small>Giải đấu có 4 trạng thái quan trọng:</small>
                    <small>
                        <ul>
                            <li>
                                <span class="label label-danger">Đóng</span>
                                : Khi một giải đấu đã kết thúc, đóng giải đấu để lưu trữ kết quả
                            </li>
                            <li>
                                <span class="label label-default">Chưa kích hoạt</span>
                                : Khi tạo giải đấu và không cho phép đăng ký, giải đấu sẽ ở trạng thái </code>Chưa kích hoạt</code>. 
                                Có thể <code>Kích hoạt</code> để đưa về trạng thái <code>Hoạt động</code>
                            </li>
                            <li>
                                <span class="label label-success">Đăng ký</span>
                                : Khi tạo giải đấu và cho phép đăng ký, giải đấu ở trạng thái <code>Đăng ký</code>.
                                Có thẻ <code>Kết thúc đăng ký</code> để đưa về trạng thái <code>Hoạt động</code>
                            </li>
                            <li>
                                <span class="label label-primary">Hoạt động</span>
                                : Là trạng thái giải đấu đang diễn ra. Ở trạng thái này, BTC giải có thể cập nhật, quản lý giải đấu.
                                Có thể <code>Kết thúc hoạt động</code> để đưa về trạng thái <code>Đóng</code>
                            </li>
                        </ul>
                    </small>
                </div>

                <!-- Modal change status to active -->
                <div class="modal fade" id="satusModal" tabindex="-1" role="dialog" aria-labelledby="satusModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6 class="modal-title" id="satusModalLabel">Xác nhận</h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="text-center">
                                        <input type="text" id="slug" value="{{ $tournament->slug }}" hidden>
                                        @switch($tournament->status)
                                            @case(1)
                                                <p>Bạn muốn kích hoạt giải đấu về trạng thái <code>Hoạt động</code> không?</p>
                                                <input type="number" id="change_status" value="4" hidden>
                                                @break
                                            @case(2)
                                                <p>Bạn muốn kích hoạt giải đấu về trạng thái <code>Hoạt động</code> không?</p>
                                                <input type="number" id="change_status" value="4" hidden>
                                                @break
                                            @case(3)
                                                <p>Bạn muốn kết thúc đăng ký đưa trạng thái về <code>Hoạt động</code> không?</p>
                                                <input type="number" id="change_status" value="4" hidden>
                                                @break
                                            @case(4)
                                                <p>Bạn muốn <code>Đóng</code> giải đấu để lưu trữ không?</p>
                                                <input type="number" id="change_status" value="1" hidden>
                                                @break
                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn-primary submit-change">Đồng ý</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* Show Modal Update Logo*/
        $(document).on('click', '.btn-status-active', function(){
            $('#satusModal').modal('show');
        });
        
        $('.submit-change').on('click', function(e){
			e.preventDefault();
            var status = $('#change_status').val();
            var slug = $('#slug').val();
            var url = "{{ route('tournament.update-status', [":slug",":status"]) }}";
            url = url.replace(':slug', slug);
            url = url.replace(':status', status);
            console.log(url);
            $.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: { 
                    'slug': slug,
                    'status': status,
                },
                success:function(data){
                    $('#satusModal').modal('hide');
                    location.reload();
                }
            });
        });
    </script>
    <script>
        /* Notification with Toastr*/
        toastr.options.positionClass = 'toast-top-right';
        @if(Session::has('update_status'))
            toastr.success("{{ Session::get('update_status') }}");
        @endif
    </script>
@endsection

