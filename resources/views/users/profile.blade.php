@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="profile-section profile-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-text text-center">
                        <h4>Thông tin tài khoản cá nhân</h4>
                    </div>
                </div>
                <form action="{{ route('user.update', $user->username) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="col-md-4">
                        <div class="profile-avatar">
                            @if(isset($user->avatar))
                                <img src="{{ asset('/uploads/avatars').'/'.$user->avatar }}" >
                            @else
                                <img src="{{ asset('/uploads/avatars/avatar_default.jpg') }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <input class="file-input" type="file" name="avatar" value="{{ $user->avatar }}">
                            @if ($errors->has('avatar'))
                                <p class="error-danger error-avatar">{{ $errors->first('avatar') }}</p>
                            @endif
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
        </div>
    </div>
@endsection

@section('foot')
    
@endsection