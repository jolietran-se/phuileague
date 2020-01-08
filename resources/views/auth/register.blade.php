@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 body">
            <div class="card">
                <div class="card-header text-center">
                    <h3>PhuiLeague</h3>
                    <h6>Thêm tài khoản mới</h6>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <p class="col-md-4 text-md-right">{{ __('Username') }}</p>
                            <div class="col-md-8">
                                <input id="username" type="text" placeholder="phuongtran" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-md-4 text-md-right">{{ __('Địa chỉ email') }}</p>
                            <div class="col-md-8">
                                <input id="email" type="email" placeholder="phuong.tt156275@student.hust.edu.vn" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-md-4 text-md-right">{{ __('Mật khẩu') }}</p>
                            <div class="col-md-8">
                                <input id="password" type="password" placeholder="********" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <p class="col-md-4 text-md-right">{{ __('Xác nhận mật khẩu') }}</p>
                            <div class="col-md-8">
                                <input id="password-confirm" type="password" placeholder="********" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0" id="register">
                            <div class="col-md-12 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đăng ký') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
