@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">

@endsection

@section('content')
    <div class="tournament-section tournament-main">
        <div class="container">
            <div class="page-header profile-text">
                <h4>Tạo giải đấu</h4>
                <small>Chọn hình thức thi đấu phù hợp với số lượng đội bóng tham gia</small>
                <small>(<span class="required"> *</span> là thuộc tính bắt buộc!)</small>
            </div>
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 create-tournament">
                            <!-- Loho giải đấu -->
                            <div class="col-md-6">
                                <div class="text-center">
                                    <label>Ảnh bìa giải đấu</label>
                                    <br><small>(banner, poster, logo)</small>
                                </div>
                                <div class="logo-tournament">
                                    <div id="preview-crop-logo">
                                        <img src="{{ asset('/storage/logos/banner_default.png') }}">
                                    </div>
                                    <button type="button" class="btn btn-submit set-logo-tournament" data-toggle="modal" data-target="#logoModal">
                                        Thêm ảnh
                                    </button>
                                </div>
                            </div>
                            <!-- Modal Upload -->
                            <div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content update-banner">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h6 class="modal-title" id="myModalLabel">Đặt lại Logo</h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class=" text-center">
                                                    <div id="upload-demo"></div>
                                                </div>
                                                <div>
                                                    <strong class="text-center text-select">Select image to crop:</strong>
                                                    <input type="file" id="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn-primary btn-block upload-image">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin giải đấu -->
                            <form action="{{ route('tournament.store') }}" method="post" id="tournament-create">
                                {{ csrf_field() }}
                                <!-- Thông tin cơ bản -->
                                <div class="col-md-6"><br>
                                    <div class="form-group">
                                        <label>Tên giải đấu</label><span class="required"> *</span>
                                        <input class="form-control" type="text" name="name" placeholder="World Cup 2019">
                                        @if ($errors->has('name'))
                                            <p class="error-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Giới tính</label><span class="required"> *</span>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="0">Nữ</option>
                                            <option value="1">Nam</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <p class="error-danger">{{ $errors->first('gender') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Sân thi đấu</label>
                                        <input class="form-control" type="string" name="stadium" placeholder="Camp Nou">
                                        @if ($errors->has('stadium'))
                                            <p class="error-danger">{{ $errors->first('stadium') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Địa điểm</label>
                                        <input class="form-control" type="string" name="address" placeholder="thành phố Barcelona, Tây Ban Nha">
                                        @if ($errors->has('address'))
                                            <p class="error-danger">{{ $errors->first('address') }}</p>
                                        @endif
                                    </div>
                                    <div id="upload-logo">
                                        @if ($errors->has('logo'))
                                            <p class="error-danger">{{ $errors->first('logo') }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Hình thức thi đấu -->
                                @if (Route::has('login'))
                                    <input type="hidden" name="owner_id" value="{{ Auth::user()->id }}">
                                @endif
                                <div class="col-md-12">
                                    <div class="tournament-type">
                                        <label for="">Hình thức thi đấu:</label><span class="required"> *</span>
                                        <small>(Hình thức thi đấu không thể thay đổi sau khi tạo giải đấu)</small>
                                        <div id="tournament_type">
                                            <input type="number" name="tournament_type" value="" hidden>
                                        </div>
                                        <div id="tab-list">
                                            <ul class="nav nav-tabs">
                                                <li class="tablink"  id="type01">
                                                    <small>Đấu loại trực tiếp</small>
                                                    <img src="{{ asset('images/logo/format01.png') }}" class="image-circle">
                                                </li>
                                                <li class="tablink" id="type02">
                                                    <small>Đấu vòng tròn</small>
                                                    <img src="{{ asset('images/logo/format02.png') }}" class="image-circle">
                                                </li>
                                                <li class="tablink" id="type03">
                                                    <small>Đấu hai giai đoạn</small>
                                                    <img src="{{ asset('images/logo/format03.png') }}" class="image-circle">
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="tabcontent">
                                            <div id="01" class="subtab none">
                                                <div class="form-group">
                                                    <label>Số đội tham gia</label><span class="required"> *</span>
                                                    <input class="form-control" type="number" min="6" name="number_club" placeholder="32">
                                                    @if ($errors->has('number_club'))
                                                        <p class="error-danger">{{ $errors->first('number_club') }}</p>
                                                    @endif
                                                </div>
                                                
                                            </div>
                                            <div id="02" class="subtab none">
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label>Điểm thắng:</label><span class="required"> *</span>
                                                        <input class="form-control" type="number" min="0" name="score_win" placeholder="3">
                                                        @if ($errors->has('score_win'))
                                                            <p class="error-danger">{{ $errors->first('score_win') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label>Điểm hòa:</label><span class="required"> *</span>
                                                        <input class="form-control" type="number" name="score_draw" placeholder="1">
                                                        @if ($errors->has('score_draw'))
                                                            <p class="error-danger">{{ $errors->first('score_draw') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label>Điểm thua:</label><span class="required"> *</span>
                                                        <input class="form-control" type="number" name="score_lose" placeholder="0">
                                                        @if ($errors->has('score_lose'))
                                                            <p class="error-danger">{{ $errors->first('score_lose') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Số lượt đá vòng tròn</label><span class="required"> *</span>
                                                    <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                                        <label class="btn tabOption active">
                                                            <input id="single" checked="checked" name="number_round" type="radio" value="1">1 lượt
                                                        </label>
                                                        <label class="btn tabOption">
                                                            <input id="single" name="number_round" type="radio" value="2">2 lượt
                                                        </label>
                                                        <label class="btn tabOption">
                                                            <input id="single" name="number_round" type="radio" value="3">3 lượt
                                                        </label>
                                                        <label class="btn tabOption">
                                                            <input id="single" name="number_round" type="radio" value="4">4 lượt
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="03" class="subtab none">
                                                <div class="form-group row">
                                                    <div class="col-xs-6">
                                                        <label>Số bảng đấu</label><span class="required"> *</span><br>
                                                        <small>(giai đoạn 1: chia bảng đấu vòng tròn)</small>
                                                        <input class="form-control" type="number" min="2" name="number_group" placeholder="8">
                                                        @if ($errors->has('number_group'))
                                                            <p class="error-danger">{{ $errors->first('number_group') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label>Số đội vào vòng knockout</label><span class="required"> *</span><br>
                                                        <small>(giai đoạn 2: loại trực tiếp)</small>
                                                        <select name="number_knockout" id="number_knockout" class="form-control">
                                                            <option value="2">2</option>
                                                            <option value="4">4</option>
                                                            <option value="8">8</option>
                                                            <option value="16">16</option>
                                                            <option value="32">32</option>
                                                            <option value="64">64</option>
                                                        </select>
                                                        @if ($errors->has('number_knockout'))
                                                            <p class="error-danger">{{ $errors->first('number_knockout') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Số lượng cầu thủ -->
                                <div class="col-md-12">
                                    <!-- Số lượng cầu thủ -->
                                    <div id="number-member" class="form-group">
                                        <label>Số cầu thủ thi đấu trên sân:</label>
                                        <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                            <label class="btn tabOption active">
                                                <input id="single" checked="checked" name="number_player" type="radio" value="5">5
                                            </label>
                                            <label class="btn tabOption">
                                                <input id="single" name="number_player" type="radio" value="7">7
                                            </label>
                                            <label class="btn tabOption">
                                                <input id="single" name="number_player" type="radio" value="9">9
                                            </label>
                                            <label class="btn tabOption">
                                                <input id="single" name="number_player" type="radio" value="11">11
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="register">
                                            <label>
                                                Cho phép đăng ký tham gia:
                                                <input type="checkbox" name="register_permission" id="register_permission">
                                            </label>
                                        </div>
                                        <div id="reject">
                                            <small>Giải đấu này sẽ do bạn tự quản lý và không cho phép các đội bóng trong hệ thống đăng ký tham gia.</small><br>
                                        </div>
                                        <div id="allow" class="none form-group">
                                            <small>Bạn sẽ mở giải đấu này cho các đội bóng trong hệ thống đăng ký. Hãy chú ý danh sách đăng ký và chia sẻ thông tin của giải đến các đội</small><br>
                                            <label>Ngày hết hạn đăng ký:</label>
                                            <input class="form-control" id="register_date" name="register_date" placeholder="DD/MM/YYY" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button id="tournament-create" type="submit" class="btn btn-primary submit-create">Tạo giải đấu</button>
                                </div>
                            </form>
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
    <script type="text/javascript">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        /* Show Modal Update Logo*/
        $(document).on('click', '.btn-lg', function(){
            $('#logoModal').modal('show');
        });
        /*Upload logo*/
            // Resize Image
            var resize = $('#upload-demo').croppie({
                enableExif: true,
                enableOrientation: true,    
                viewport: { // Default { width: 100, height: 100, type: 'square' } 
                    width: 770.5,
                    height: 460,
                    type: 'square' //square
                },
                boundary: {
                    width: 790,
                    height: 480
                }
            });
            // Upload image cut
            $('#image').on('change', function () { 
            var reader = new FileReader();
                reader.onload = function (e) {
                resize.croppie('bind',{
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
                }
                reader.readAsDataURL(this.files[0]);
            });
            // Demo image
            $('.upload-image').on('click', function (ev) {
                // var username = $('#username').val();
                resize.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (img) {
                    // console.log(username);
                    $.ajax({
                        url: '{!! route("tournament.crop-logo") !!}',
                        dataType : 'json',
                        type: 'post',
                        data: {
                            'image':img,
                            // 'username': username,
                        },
                        success: function (data) {
                            var image_name = data.image_name;
                            // console.log(image_name);
                            $('#logoModal').modal('hide');

                            html = '<img src="' + img + '" />';
                            logo = '<input name="logo" value ="' + image_name + '" hidden>';
                            $("#upload-logo").html(logo);
                            $("#preview-crop-logo").html(html);
                        }
                    });
                });
            });
        /*End Upload logo*/

        /* Show form-group after click tab-list*/
        $(document).ready(function(){
            $("#01").show();
            var x = document.getElementById("type01");
            var y = document.getElementById("type02");
            var z = document.getElementById("type03");
            $("#type01").click(function(){
                x.style.background = "#326295";
                y.style.background = "#d87474";
                z.style.background = "#d87474";
                $("#02").hide();
                $("#03").hide();
                var type = $("#01").attr("id");
                tournament_type = "<input type='number' name='tournament_type_id' value='"+type+"' hidden>";
                console.log(tournament_type);
                 $("#tournament_type").html(tournament_type);
            });
            $("#type02").click(function(){
                x.style.background = "#d87474";
                y.style.background = "#326295";
                z.style.background = "#d87474";
                $("#02").slideDown();
                $("#03").hide();
                var type = $("#02").attr("id");
                tournament_type = "<input type='number' name='tournament_type_id' value='"+type+"' hidden>";
                console.log(tournament_type);
                $("#tournament_type").html(tournament_type);
            });
            $("#type03").click(function(){
                x.style.background = "#d87474";
                y.style.background = "#d87474";
                z.style.background = "#326295";
                $("#02").show();
                $("#03").slideDown();
                var type = $("#03").attr("id");
                tournament_type = "<input type='number' name='tournament_type_id' value='"+type+"' hidden>";
                console.log(tournament_type);
                $("#tournament_type").html(tournament_type);
            });
            
        });

        /*Register Permission*/
        $("#register_permission").click(function () {
            if ($(this).is(":checked")) {
                $("#allow").slideDown();
                $("#reject").hide();
            } else {
                $("#allow").hide();
                $("#reject").show();
            }
        });
        /* Register Date Format */
        $(document).ready(function(){
            var date_input=$('input[name="register_date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
                format: 'dd-mm-yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);
        })
    </script>

    <script>
        /* Notification with Toastr*/
        toastr.options.positionClass = 'toast-bottom-right';
        @if(Session::has('create_tournament'))
            toastr.success("{{ Session::get('create_tournament') }}");
        @endif    
    </script>
@endsection