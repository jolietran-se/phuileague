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
                    <h6>Đăng nhập vào PhuiLeague</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row" id="user">
                            <p class="col-md-4 text-md-right">{{ __('Username hoặc Email') }}</p>
                            <div class="col-md-8">
                                <input id="login" type="text"
                                class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                name="login" value="{{ old('username') ?: old('email') }}" required autofocus>
                                @if ($errors->has('username') || $errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="pass">
                            <p class="col-md-4 text-md-right">{{ __('Mật khẩu') }}</p>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row" id="remember">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{ __('Remember Me') }}
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group row mb-0" id="login">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đăng nhập') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Quên mật khẩu?') }}
                                    </a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="btn btn-link pull-right" href="{{ route('register') }}">
                                        {{ __('Thêm tài khoản mới?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')
@endsection