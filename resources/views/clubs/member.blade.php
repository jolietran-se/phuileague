@extends('layouts.master')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
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
                        <li role="presentation"><a href="{{ route('club.profile', $club->slug)}}">Thông tin chung<span class="glyphicon glyphicon-chevron-right"></a></li>
                        <li role="presentation"><a href="{{ route('club.setting', $club->slug)}}">Chỉnh sửa thông tin đội<span class="glyphicon glyphicon-chevron-right"></a></li>
                            <li role="presentation" class="active"><a href="{{ route('club.member', $club->slug)}}">Thành viên<span class="glyphicon glyphicon-chevron-right"></a></li>
                        <li role="presentation"><a href="{{ route('club.statistic', $club->slug)}}">Thống kê<span class="glyphicon glyphicon-chevron-right"></a></li>
                    </ul>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-md-8">
                <div class="panel panel-success">
                    <!-- DANH SÁCH THÀNH VIÊN -->
                    <div class="page-header text-center">
                        <h6><strong>Danh sách thành viên</strong></h6>
                        Có tất cả {{ isset($club->number_player)?$club->number_player:0 }} thành viên
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-list"></span>
                            Danh sách thành viên
                        </div>
                        @foreach ($players as $player)
                            <div class="col-md-3" id="demo-avatar">
                                <div class="thumbnail">
                                    @if (isset($player->avatar))
                                        <img src="{{ asset('storage/player-avatars/').'/'.$player->avatar }}" alt="...">
                                    @else
                                        <img src="{{ asset('storage/player-avatars/avatar_default.jpg') }}" alt="...">
                                    @endif
                                    <div class="caption text-center">
                                        <small><b>{{ $player->name }}</b></small><br>
                                        <small>Số áo: {{ $player->uniform_number }}</small><br>
                                        <small>Vị trí: 
                                            @switch($player->position)
                                                @case(1)
                                                    Thủ môn
                                                    @break
                                                @case(2)
                                                    Hậu vệ
                                                    @break
                                                @case(3)
                                                    Tiền vệ
                                                    @break
                                                @case(4)
                                                    Tiền đạo
                                                    @break
                                                @case(5)
                                                    Khác
                                                    @break
                                                @default
                                            @endswitch
                                        </small><br>
                                        <small>{{ $player->ismain==1?"Đội hình thi đấu":"Đội hình dự bị" }}</small><br>
                                        <small>
                                            <a href="#" class="btn btn-default edit-player" role="button"
                                                data-id="{{ $player->id }}"
                                                data-name = "{{ $player->name }}"
                                                data-avatar = "{{ $player->avatar }}"
                                                data-uniform-number = "{{ $player->uniform_number }}"
                                                data-uniform-name = "{{ $player->uniform_name }}"
                                                data-birthday = "{{ $player->birthday }}"
                                                data-position = "{{ $player->position }}"
                                                data-role = "{{ $player->role }}"
                                                data-front-idcard = "{{ $player->front_idcard }}"
                                                data-backside-idcard = "{{ $player->backside_idcard }}"
                                                data-phone = "{{ $player->phone }}"
                                                data-ismain = "{{ $player->ismain }}"
                                            ><small>Chi tiết</small></a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><hr>
                    <!-- THÊM THÀNH VIÊN -->
                    <div class="panel-body">
                        <div class="col-md-12"><span class="glyphicon glyphicon-plus"></span>Thêm thành viên</div>
                        <div class="col-md-12">
                            <!-- Avatar -->
                            <div class="col-md-3">
                                <div id="player-avatar">
                                    <div id="preview-crop-avatar">
                                        <img src="{{ asset('/storage/player-avatars/avatar_default.jpg') }}">
                                    </div>
                                    <button type="button" class="btn btn-submit set-avatar" data-toggle="modal" data-target="#avatarModal">
                                        Thêm
                                    </button>
                                </div>
                            </div>
                            <!-- Thêm thông tin -->
                            <form action="{{ route('club.add-member', $club->slug) }}" method="post" id="form-create">
                                {{ csrf_field() }}
                                <div id="upload-avatar"></div>
                                <input type="hidden" name="club_id" value="{{ $club->id }}">
                                <div class="col-md-4" id="player-info">
                                    <div class="form-group">
                                        <input type="number"class="form-control" name="uniform_number" id="uniform_number" placeholder="Số áo thi đấu">
                                    </div>
                                    <div class="form-group">
                                        <input type="text"class="form-control" name="uniform_name" id="uniform_name" placeholder="Tên thi đấu">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="position" id="position">
                                            <option value="1">Thủ môn</option>
                                            <option value="2">Hậu vệ</option>
                                            <option value="3">Tiền vệ</option>
                                            <option value="4">Tiền đạo</option>
                                            <option value="5">Khác</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="role" id="role">
                                            <option value="1">Vận động viên</option>
                                            <option value="2">HLV Trưởng</option>
                                            <option value="3">HLV Thủ môn</option>
                                            <option value="4">HLV Thể lực</option>
                                            <option value="5">Trợ lý HLV</option>
                                            <option value="6">Đội trưởng</option>
                                            <option value="7">Đội phó</option>
                                            <option value="8">Ông bầu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="player-info">
                                    <div class="form-group">
                                        <input type="text"class="form-control" name="name" id="name" placeholder="Họ và tên đầy đủ">
                                    </div>
                                    <div class="form-group">
                                        <input type="text"class="form-control" name="phone" id="phone" placeholder="Số điện thoại">
                                    </div>
                                    <div class="form-group">
                                        <input type="text"class="form-control" name="birthday" id="birthday" placeholder="Ngày tháng năm sinh">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="ismain" id="ismain">
                                            <option value="1">Đội hình thi đấu</option>
                                            <option value="2">Đội hình dự bị</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success" value="Lưu">
                                </div>
                            </form>

                            <!-- Avatar Upload Modal -->
                            <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content update-banner">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Đặt lại Đồng phục</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class=" text-center">
                                                    <div id="avatar-demo"></div>
                                                </div>
                                                <div>
                                                    <strong class="text-center text-select">Select image to crop:</strong>
                                                    <input type="file" id="avatar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-primary btn-block upload-avatar">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Player Edit Modal -->
                            <div class="modal fade" id="editPlayerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Thông tin chi tiết</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4" id="edit-avatar">
                                                    <small>Avatar: </small>
                                                    <a href="#" class="btn btn-default edit-avatar" role="button" id="show-avatar">
                                                        <!--  show avatar -->
                                                    </a>
                                                    <hr>
                                                    <small>Mặt trước thẻ căn cước:</small>
                                                    <a href="#" class="btn btn-default edit-front" role="button" id="show-front">
                                                        <!-- show front of idcard -->
                                                    </a><br>
                                                    <small>Mặt sau thẻ căn cước:</small>
                                                    <a href="#" class="btn btn-default edit-backside" role="button" id="show-backside">
                                                        <!-- show backside of idcard -->
                                                    </a>
                                                </div>
                                                <form class="form-horizontal" role="form" method="post">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" id="club-slug" value="{{ $club->slug }}">
                                                    <input type="hidden" id="player-id">
                                                    <div id="input-avatar"></div>
                                                    <div id="input-front"></div>
                                                    <div id="input-backside"></div>
                                                    <div class="col-md-8">
                                                        <table>
                                                            <tr>
                                                                <td><small>Họ và tên đầy đủ: </small></td>
                                                                <td><input class="form-control" type="text" name="edit_name" id="edit-name"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Tên thi đấu: </small></td>
                                                                <td><input  class="form-control" type="text" name="edit_uniform_name" id="edit-uniform-name"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Số áo: </small></td>
                                                                <td><input class="form-control" type="text" name="edit_uniform_number" id="edit-uniform-number"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Vị trí:</small></td>
                                                                <td id="edit-position">
                                                                    <select class="form-control" name="edit_position">
                                                                        <option value="1">Thủ môn</option>
                                                                        <option value="2">Hậu vệ</option>
                                                                        <option value="3">Tiền vệ</option>
                                                                        <option value="4">Tiền đạo</option>
                                                                        <option value="5">Khác</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Vai trò: </small></td>
                                                                <td id="edit-role">
                                                                    <select class="form-control" name="edit_role" >
                                                                        <option value="1">Vận động viên</option>
                                                                        <option value="2">HLV Trưởng</option>
                                                                        <option value="3">HLV Thủ môn</option>
                                                                        <option value="4">HLV Thể lực</option>
                                                                        <option value="5">Trợ lý HLV</option>
                                                                        <option value="6">Đội trưởng</option>
                                                                        <option value="7">Đội phó</option>
                                                                        <option value="8">Ông bầu</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Đội hình: </small></td>
                                                                <td id="edit-ismain">
                                                                    <select class="form-control" name="edit_ismain">
                                                                        <option value="1">Đội hình thi đấu</option>
                                                                        <option value="2">Đội hình dự bị</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Điện thoại: </small></td>
                                                                <td> <input class="form-control" type="text" name="edit_phone" id="edit-phone"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><small>Ngày sinh: </small></td>
                                                                <td><input class="form-control" type="text" name="edit_birthday" id="edit-birthday"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-block update-player" data-dismiss="modal">Lưu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Avatar Edit Modal -->
                            <div class="modal fade" id="editAvatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content update-banner">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Ảnh đại diện</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class=" text-center">
                                                    <div id="avatar-edit-demo"></div>
                                                </div>
                                                <div>
                                                    <strong class="text-center text-select">Select image to crop:</strong>
                                                    <input type="file" id="avatar-edit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-primary btn-block upload-avatar-edit">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Front Edit Modal -->
                            <div class="modal fade" id="editFrontModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content update-banner">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Mặt trước thẻ căn cước</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class=" text-center">
                                                    <div id="front-edit-demo"></div>
                                                </div>
                                                <div>
                                                    <strong class="text-center text-select">Select image to crop:</strong>
                                                    <input type="file" id="front-edit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-primary btn-block upload-front-edit">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Front Edit Modal -->
                            <div class="modal fade" id="editBacksideModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content update-banner">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Mặt sau thẻ căn cước</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class=" text-center">
                                                    <div id="backside-edit-demo"></div>
                                                </div>
                                                <div>
                                                    <strong class="text-center text-select">Select image to crop:</strong>
                                                    <input type="file" id="backside-edit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-primary btn-block upload-backside-edit">Cập nhật</button>
                                        </div>
                                    </div>
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
    <script src="{{ asset('bower_components/Croppie/croppie.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    
    <!-- Register Date Format -->
    <script type="text/javascript">
        $(document).ready(function(){
            var date_input=$('input[name="birthday"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                format: 'dd/mm/yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);
        })
    </script>

    <!-- Upload images -->
    <script type="text/javascript">
        $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });
       $(document).on('click', '.set-avatar', function(){
           $('#avatarModal').modal('show');
       });

       /*Upload Uniform*/
           // Resize Image
           var resize_uniform = $('#avatar-demo').croppie({
               enableExif: true,
               enableOrientation: true,    
               viewport: { // Default { width: 100, height: 100, type: 'square' } 
                   width: 300,
                   height: 300,
                   type: 'square' //square
               },
               boundary: {
                   width: 400,
                   height: 400
               }
           });
           // Upload image cut
           $('#avatar').on('change', function () { 
           var reader_uniform = new FileReader();
               reader_uniform.onload = function (e) {
               resize_uniform.croppie('bind',{
                   url: e.target.result
               }).then(function(){
                   console.log('jQuery bind complete');
               });
               }
               reader_uniform.readAsDataURL(this.files[0]);
           });
           // Demo image
           $('.upload-avatar').on('click', function (ev) {
               resize_uniform.croppie('result', {
                   type: 'canvas',
                   size: 'viewport'
               }).then(function (img) {
                   $.ajax({
                       url: '{!! route("club.crop-avatar") !!}',
                       dataType : 'json',
                       type: 'post',
                       data: {
                           'avatar':img,
                       },
                       success: function (data) {
                           var avatar_name = data.file_name;
                           // console.log(image_name);
                           $('#avatarModal').modal('hide');

                           html2 = '<img src="' + img + '" />';
                           avatar = '<input name="avatar" value ="' + avatar_name + '" hidden>';
                           $("#upload-avatar").html(avatar);
                           $("#preview-crop-avatar").html(html2);
                       }
                   });
               });
           });
       /*End Upload logo*/
    </script>

    <!-- Edit player-->
    <script type="text/javascript">
       $(document).on('click', '.edit-player', function(){
            $('#editPlayerModal').modal('show');
            // Lấy thông tin
            $('#player-id').val($(this).data('id'));
            $('#edit-name').val($(this).data('name'));
            $('#edit-uniform-name').val($(this).data('uniform-name'));
            $('#edit-uniform-number').val($(this).data('uniform-number'));
            $('#edit-phone').val($(this).data('phone'));
            $('#edit-birthday').val($(this).data('birthday'));

            $("td#edit-position select").val($(this).data('position'));
            $("td#edit-role select").val($(this).data('role'));
            $("td#edit-ismain select").val($(this).data('ismain'));
            // Hiển thị ảnh
            var avatar_name = $(this).data('avatar');
            var front_name = $(this).data('front-idcard');
            var backside_name = $(this).data('backside-idcard');
            
            if (avatar_name != "") {
                avatar = '<img src="{{ asset("storage/player-avatars/")."/".':avatar_name'}}"/>'
                avatar = avatar.replace(':avatar_name', avatar_name);
            } else {
                avatar = '<img src="{{ asset("storage/player-avatars/avatar_default.jpg") }}"/>'
            }
            if (front_name != "") {
                front_idcard = '<img src="{{ asset("storage/player-avatars/")."/".':front_name'}}"/>'
                front_idcard = front_idcard.replace(':front_name', front_name);
            } else {
                front_idcard = '<img src="{{ asset("storage/player-avatars/idcard.jpg") }}"/>'
            }
            if (backside_name != "") {
                backside_idcard = '<img src="{{ asset("storage/player-avatars/")."/".':backside_name'}}" />'
                backside_idcard = backside_idcard.replace(':backside_name', backside_name);
            } else {
                backside_idcard = '<img src="{{ asset("storage/player-avatars/idcard.jpg") }}" />'
            }
            $("#show-avatar").html(avatar);
            $("#show-front").html(front_idcard);
            $("#show-backside").html(backside_idcard);

            // Edit-birthday
            $(document).ready(function(){
                var date_input=$('input[name="edit_birthday"]');
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                var options={
                    format: 'dd/mm/yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                };
                date_input.datepicker(options);
            });

            /*Đổi avatar*/    
            $(document).on('click', '.edit-avatar', function(){
                $('#editAvatarModal').modal('show');
                // Resize Image
                    var resize_uniform = $('#avatar-edit-demo').croppie({
                        enableExif: true,
                        enableOrientation: true,    
                        viewport: { // Default { width: 100, height: 100, type: 'square' } 
                            width: 300,
                            height: 300,
                            type: 'square' //square
                        },
                        boundary: {
                            width: 400,
                            height: 400
                        }
                    });
                // Upload image cut
                $('#avatar-edit').on('change', function () { 
                var reader_uniform = new FileReader();
                    reader_uniform.onload = function (e) {
                    resize_uniform.croppie('bind',{
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                    }
                    reader_uniform.readAsDataURL(this.files[0]);
                });
                // Demo image
                $('.upload-avatar-edit').on('click', function (ev) {
                    resize_uniform.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (img) {
                        $.ajax({
                            url: '{!! route("club.crop-avatar") !!}',
                            dataType : 'json',
                            type: 'post',
                            data: {
                                'avatar':img,
                            },
                            success: function (data) {
                                var avatar_fname = data.file_name;
                                input_avatar = '<input id="update-avatar" value ="' + avatar_fname + '" hidden>';
                                $("#input-avatar").html(input_avatar);
                                console.log('avatar'+input_avatar);
                                $('#editAvatarModal').modal('hide');
                                html = '<img src="' + img + '" />';
                                $("#show-avatar").html(html);
                            }
                        });
                    });
                });
            });

            /*Đổi mặt trước thẻ căn cước*/    
            $(document).on('click', '.edit-front', function(){
                $('#editFrontModal').modal('show');
                // Resize Image
                    var resize_uniform = $('#front-edit-demo').croppie({
                        enableExif: true,
                        enableOrientation: true,    
                        viewport: { // Default { width: 100, height: 100, type: 'square' } 
                            width: 300,
                            height: 200,
                            type: 'square' //square
                        },
                        boundary: {
                            width: 350,
                            height: 250
                        }
                    });
                // Upload image cut
                $('#front-edit').on('change', function () { 
                var reader_uniform = new FileReader();
                    reader_uniform.onload = function (e) {
                    resize_uniform.croppie('bind',{
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                    }
                    reader_uniform.readAsDataURL(this.files[0]);
                });
                // Demo image
                $('.upload-front-edit').on('click', function (ev) {
                    resize_uniform.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (img) {
                        $.ajax({
                            url: '{!! route("club.crop-avatar") !!}',
                            dataType : 'json',
                            type: 'post',
                            data: {
                                'avatar':img,
                            },
                            success: function (data) {
                                var front_fname = data.file_name;
                                input_front = '<input id="update-front" value ="' + front_fname + '" hidden>';
                                $("#input-front").html(input_front);
                                console.log('front'+input_front);
                                $('#editFrontModal').modal('hide');
                                html = '<img src="' + img + '" />';
                                $("#show-front").html(html);
                            }
                        });
                    });
                });
            });
            /*Đổi mặt sau thẻ căn cước*/    
            $(document).on('click', '.edit-backside', function(){
                $('#editBacksideModal').modal('show');
                // Resize Image
                    var resize_uniform = $('#backside-edit-demo').croppie({
                        enableExif: true,
                        enableOrientation: true,    
                        viewport: { // Default { width: 100, height: 100, type: 'square' } 
                            width: 300,
                            height: 200,
                            type: 'square' //square
                        },
                        boundary: {
                            width: 350,
                            height: 250
                        }
                    });
                // Upload image cut
                $('#backside-edit').on('change', function () { 
                var reader_uniform = new FileReader();
                    reader_uniform.onload = function (e) {
                    resize_uniform.croppie('bind',{
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                    }
                    reader_uniform.readAsDataURL(this.files[0]);
                });
                // Demo image
                $('.upload-backside-edit').on('click', function (ev) {
                    resize_uniform.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (img) {
                        $.ajax({
                            url: '{!! route("club.crop-avatar") !!}',
                            dataType : 'json',
                            type: 'post',
                            data: {
                                'avatar':img,
                            },
                            success: function (data) {
                                var backside_fname = data.file_name;
                                input_backside = '<input id="update-backside" value ="' + backside_fname + '" hidden>';
                                $("#input-backside").html(input_backside);
                                console.log('backside'+input_backside);
                                $('#editBacksideModal').modal('hide');
                                html = '<img src="' + img + '" />';
                                $("#show-backside").html(html);
                            }
                        });
                    });
                });
            });

            $('.modal-footer').on('click', '.update-player', function(e) {
                e.preventDefault();
                var club_slug = $('#club-slug').val();
                var url = "{{ route('club.edit-member', ":slug") }}";
                url = url.replace(':slug', club_slug);

                var player_id = $('#player-id').val();
                var name = $('#edit-name').val();
                var uniform_name = $('#edit-uniform-name').val();
                var uniform_number = $('#edit-uniform-number').val();
                var phone = $('#edit-phone').val();
                var birthday = $('#edit-birthday').val();
                var position = $('option:selected', '#edit-position').val()
                var role = $('option:selected', '#edit-role').val()
                var ismain = $('option:selected', '#edit-ismain').val()

                var avatar = $('#update-avatar').val();
                if(avatar == undefined){
                    avatar = $(this).data('avatar');
                }
                var front_idcard = $('#update-front').val();
                var backside_idcard = $('#update-backside').val();
                console.log(avatar);
                
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url: url,
                    data:{
                        'player_id': player_id,
                        'name': name,
                        'uniform_name': uniform_name,
                        'uniform_number': uniform_number,
                        'phone': phone,
                        'birthday': birthday,
                        'position': position,
                        'role': role,
                        'ismain': ismain,
                        'avatar': avatar,
                        'front_idcard': front_idcard,
                        'backside_idcard': backside_idcard,
                    },
                    success:function(){
                        $('#editPlayerModal').modal('hide');
                        location.reload();
                    }, error: function(xhr, textStatus, thrownError) {
                        location.reload();
                    },
                });
            });
       });
    </script>
@endsection