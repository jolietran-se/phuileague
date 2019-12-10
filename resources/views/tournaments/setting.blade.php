@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

@endsection

@section('content')
    <!-- Setting tab list -->
    @include('layouts.setting')

    <div class="setting-section setting-main">
        <div class="container" id="update-tournament">
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="{{ route('tournament.setting', $tournament->slug)}}">Thông tin chung <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.groupstage', $tournament->slug)}}">Sắp xếp bảng đấu <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng <span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Content: thông tin chung -->
            <div id="content" class="col-md-8">
                <div class="page-header profile-text text-center">
                    <h6><strong>Thông tin chung</strong></h6>
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
                    <small class="header-text">{{ isset($tournament->stadium)?$tournament->stadium:"Chưa cập nhật" }} |</small>
                    <small class="header-text">{{ isset($tournament->address)?$tournament->address:"Chưa cập nhật" }}</small><br>
                    <small class="header-text">{{ $tournament->number_club }} đội bóng </small>
                    @if ($tournament->tournament_type_id == 3)
                        <small class="header-text">| {{ $tournament->number_group }} bảng đấu |</small>
                        <small class="header-text">{{ $tournament->number_knockout }} đội vào vòng knockout</small>
                    @endif
                </div>
                <!-- Form cập nhật thông tin -->
                
                
                <form action="{{ route('tournament.update', $tournament->slug) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input id="input-gender" value="{{ $tournament->gender}}" hidden>
                    <input id="input-player" value="{{ $tournament->number_player }}" hidden>
                    <input id="input-round" value="{{ $tournament->number_round }}" hidden>
                    <input id="input-introduce" value="{{ $tournament->introduce }}" hidden>
                    <div class="col-md-6">
                        <!-- Thông tin cơ bản -->
                        <div class="form-group">
                            <label>Tên giải đấu:</label>
                            <input class="form-control" type="text" name="name" value="{{ $tournament->name }}">
                            @if ($errors->has('name'))
                                <p class="error-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-group" id="">
                            <label>Giới tính:</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="0">Nữ</option>
                                <option value="1">Nam</option>
                            </select>
                            @if ($errors->has('gender'))
                                <p class="error-danger">{{ $errors->first('gender') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Sân thi đấu:</label>
                            <input class="form-control" type="string" name="stadium" value="{{ $tournament->stadium }}">
                            @if ($errors->has('stadium'))
                                <p class="error-danger">{{ $errors->first('stadium') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Địa điểm:</label>
                            <input class="form-control" type="string" name="address" value="{{ $tournament->address }}">
                            @if ($errors->has('address'))
                                <p class="error-danger">{{ $errors->first('address') }}</p>
                            @endif
                        </div>
                        <div id="update-logo">
                            @if ($errors->has('logo'))
                                <p class="error-danger">{{ $errors->first('logo') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Loho giải đấu -->
                        <div >
                            <div class="text-center">
                                <label>Ảnh bìa giải đấu</label>
                                <small>(banner, poster, logo)</small>
                            </div>
                            <div class="logo-tournament">
                                <div id="preview-crop-logo">
                                    @if (isset($tournament->logo))
                                        <img src="{{ asset('/storage/logos/').'/'.$tournament->logo }}" alt="">
                                    @else
                                        <img src="{{ asset('/storage/logos/banner_default.png') }}">
                                    @endif
                                </div>
                                <button type="button" class="btn btn-submit btn-update-logo" data-toggle="modal" data-target="#logoModal">
                                    Thay ảnh bìa
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Số lượng cầu thủ -->
                        <div id="number-member" class="form-group">
                            <label>Số cầu thủ thi đấu trên sân:</label>
                            <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                <label class="btn tabOption" id="5players">
                                    <input name="number_player" type="radio" value="5"><small>5</small>
                                </label>
                                <label class="btn tabOption" id="7players">
                                    <input name="number_player" type="radio" value="7"><small>7</small>
                                </label>
                                <label class="btn tabOption" id="9players">
                                    <input name="number_player" type="radio" value="9"><small>9</small>
                                </label>
                                <label class="btn tabOption" id="11players">
                                    <input name="number_player" type="radio" value="11"><small>11</small>
                                </label>
                            </div>
                        </div>
                        <!-- Số lượt đá vòng tròn -->
                        <div class="form-group">
                            <label>Số lượt đá vòng tròn</label>
                            <small>(lượt đi, lượt về)</small>:
                            <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                <label class="btn tabOption" id="1round">
                                    <input name="number_round" type="radio" value="1">1 lượt
                                </label>
                                <label class="btn tabOption" id="2rounds">
                                    <input name="number_round" type="radio" value="2"><small>2 lượt</small>
                                </label>
                                <label class="btn tabOption" id="3rounds">
                                    <input name="number_round" type="radio" value="3"><small>3 lượt</small>
                                </label>
                                <label class="btn tabOption" id="4rounds">
                                    <input name="number_round" type="radio" value="4"><small>4 lượt</small>
                                </label>
                            </div>
                        </div>
                        <!-- Điểm thắng, điểm hòa, điểm thua -->
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label>Điểm thắng:</label>
                                <input class="form-control" type="number" name="score_win" value="{{ $tournament->score_win }}">
                                @if ($errors->has('score_win'))
                                    <p class="error-danger">{{ $errors->first('score_win') }}</p>
                                @endif
                            </div>
                            <div class="col-xs-4">
                                <label>Điểm hòa:</label>
                                <input class="form-control" type="number" name="score_draw" value="{{ $tournament->score_draw }}">
                                @if ($errors->has('score_draw'))
                                    <p class="error-danger">{{ $errors->first('score_draw') }}</p>
                                @endif
                            </div>
                            <div class="col-xs-4">
                                <label>Điểm thua:</label>
                                <input class="form-control" type="number" name="score_lose" value="{{ $tournament->score_lose }}">
                                @if ($errors->has('score_lose'))
                                    <p class="error-danger">{{ $errors->first('score_lose') }}</p>
                                @endif
                            </div>
                        </div>
                        <!-- Số lượng tối đa và hạn chót đăng ký-->
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Số lượng cầu thủ tối đa mỗi đội:</label>
                                <input type="number" class="form-control" name="max_player" value="{{ $tournament->max_player }}">
                            </div>
                            @if (isset($tournament->register_date))
                                <div class="col-xs-6">
                                    <label>Hạn chót đăng ký:</label>
                                    <input type="text" class="form-control" name="register_date" value="{{ $tournament->register_date }}">
                                </div>
                            @endif
                        </div>
                        <!-- Thông tin và điều lệ giải -->
                        <div class="form-group" id="charter" >
                            <label for="charter">Điều lệ giải:</label>
                            @if (isset($tournament->charter))
                                <a href="{{ route('tournament.charter', [ $tournament->slug, $tournament->charter]) }}"  target="_blank"> Tải xuống </a>
                            @endif
                            <input type="file" name="charter"><small>(Chỉ có thể tải lên file pdf)</small>
                        </div>
                        <div class="form-group">
                            <label for="">Giới thiệu giải: </label>
                            <textarea name="introduce" id="introduce" cols="30" rows="10">{{ $tournament->introduce }}</textarea>
                        </div>
                    </div>

                    <div id="footer" class="col-md-12">
                        <input type="submit" value="Lưu" class="btn btn-success">
                    </div>
                </form>
                <!-- END Form -->
                
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
                                    <div id="choose-file">
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
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/Croppie/croppie.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script src={{ url('bower_components/ckeditor/ckeditor.js') }}></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <!-- Selected Option và Input Radio checked -->
    <script type="text/javascript">
        var gender = $('#input-gender').val();
        var number_player = $('#input-player').val();
        var numer_round = $('#input-round').val();
		var introduce = $('#input-introduce').val();
        $("select#gender").val(gender);

        console.log(number_player);
        // Hiển thị number_player
        if (number_player==5) {
			$("#5players" ).addClass('active');
		}else if(number_player==7) {
			$("#7players" ).addClass('active');
		}else if(number_player == 9){
			$("#9players" ).addClass('active');
		}else if(number_player == 11){
			$("#11players" ).addClass('active');
		}
        // Hiển thị number_round
        if (numer_round==1) {
			$("#1round" ).addClass('active');
		}else if(numer_round==2) {
			$("#2rounds" ).addClass('active');
		}else if(numer_round ==3){
			$("#3rounds" ).addClass('active');
		}else if(numer_round == 4){
			$("#4rounds" ).addClass('active');
		}
        // Hiển thị introduce

    </script>

    <!-- Upload Banner -->
    <script type="text/javascript">
         $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        /* Show Modal Update Logo*/
        $(document).on('click', '.btn-update-logo', function(){
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
            $('.upload-image').on('click', function () {
                resize.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (img) {
                    $.ajax({
                        url: '{!! route("tournament.crop-logo") !!}',
                        dataType : 'json',
                        type: 'post',
                        data: {
                            'image':img,
                        },
                        success: function (data) {
                            var image_name = data.image_name;
                            // console.log(image_name);
                            $('#logoModal').modal('hide');

                            html = '<img src="' + img + '" />';
                            logo = '<input name="logo" value ="' + image_name + '" hidden>';
                            $("#update-logo").html(logo);
                            $("#preview-crop-logo").html(html);
                        }
                    });
                });
            });
        /*End Upload logo*/

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

    <!-- CKFinder và CKEditor -->
    <script>
        CKEDITOR.replace( 'introduce', {
            filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',

        } );
    </script>
    @include('ckfinder::setup')

    <script>
        /* Notification with Toastr*/
        toastr.options.positionClass = 'toast-bottom-right';
        @if(Session::has('update_tournament'))
            toastr.success("{{ Session::get('update_tournament') }}");
        @endif
        @if(Session::has('error_type'))
            toastr.error("{{ Session::get('error_type') }}");
        @endif  
        @if(Session::has('name_false'))
            toastr.error("{{ Session::get('name_false') }}");
        @endif    
    </script>
@endsection

