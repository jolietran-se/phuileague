@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <div class="profile-section profile-main">
        <div class="container">
            <!-- User Information --> 
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-text text-center">
                        <h4>Thông tin tài khoản cá nhân</h4>
                    </div>
                </div>
                <!-- Modal Upload -->
                <div class="col-md-12">
                    <!-- Modal -->
                    <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h6 class="modal-title" id="myModalLabel">Đặt lại ảnh đại diện</h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class=" text-center">
                                        <div id="upload-demo"></div>
                                    </div>
                                    <div>
                                        <strong class="text-center">Select image to crop:</strong>
                                        <input type="file" id="image">
                                        <input type="text" id="username" value="{{ $user->username }}" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary btn-block upload-image" style="margin-top:2%">Đặt ảnh đại diện</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Information --> 
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <form action="{{ route('user.update', $user->username) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-md-4">
                                    <div class="profile-avatar">
                                        <div id="preview-crop-image">
                                            @if(isset($user->avatar) && $user->avatar != null)
                                                <img  src="{{ asset('/storage/avatars').'/'.$user->avatar }}" >
                                            @else
                                                <img src="{{ asset('/storage/avatars/avatar_default.jpg') }}">
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-submit set-avatar" data-toggle="modal" data-target="#avatarModal">
                                            Đặt ảnh đại diện
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" type="text" name="username" value="{{ $user->username }}">
                                        @if ($errors->has('username'))
                                            <p class="error-danger">{{ $errors->first('username') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text" name="email" value="{{ $user->email }}">
                                        @if ($errors->has('email'))
                                            <p class="error-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <input class="form-control" type="string" name="phone" value="{{ $user->phone }}">
                                        @if ($errors->has('phone'))
                                            <p class="error-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Facebook cá nhân (link)</label>
                                        <input class="form-control" type="text" name="facebook_link" value="{{ $user->facebook_link }}" >
                                        @if ($errors->has('facebook_link'))
                                            <p class="error-danger">{{ $errors->first('facebook_link') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary submit">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                    <div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('foot')
    <script src="{{ asset('bower_components/Croppie/croppie.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        /* Show Modal Update Avatar*/
        $(document).on('click', '.btn-lg', function(){
            $('#avatarModal').modal('show');
        });

        /*Upload Avatar*/
        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,    
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 200,
                height: 200,
                type: 'circle' //square
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

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

        $('.upload-image').on('click', function (ev) {
            var username = $('#username').val();
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {
                // console.log(username);
                $.ajax({
                    url: '{!! route("user.crop-avatar") !!}',
                    dataType : 'json',
                    type: 'post',
                    data: {
                        'image':img,
                        'username': username,
                    },
                    success: function (data) {
                        $('#avatarModal').modal('hide');
                        html = '<img src="' + img + '" />';
                        $("#preview-crop-image").html(html);
                        @if(Session::has('update-avatar'))
                            toastr.success("{{ Session::get('update-avatar') }}");
                        @endif
                    }
                });
            });
        });
    </script>
    <script>
        /* Notification with Toastr*/
        toastr.options.positionClass = 'toast-bottom-right';
        @if(Session::has('update-account'))
            toastr.success("{{ Session::get('update-account') }}");
        @endif 
        @if(Session::has('update-avatar'))
            toastr.success("{{ Session::get('update-avatar') }}");
        @endif    
    </script>
@endsection
