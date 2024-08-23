@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="my-5 d-flex justify-content-center">
                
                <div class="login-box">
                    <div class="login-logo">
                        <a href="{{ URL::to('/') }}"><b>Matrix</b> DB Event</a>
                    </div>
                </div>
            </div>
            <form action="{{ route('login') }}" method="post" id="loginForm">
                @csrf
                <div class="card custom-card shadow-lg">
                    <div class="card-body p-5">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label text-dark">
                                        {{ __('Username') }}
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="{{ __('Username') }}" autocomplete="username" value="{{ old('username') }}">
                                    @error('username')
                                        <span id="username-error" class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <div class="form-group mb-3">
                                <label for="password" class="form-label text-dark">
                                    {{ __('Password') }}
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="{{ __('Password') }}" autocomplete="current-password">
                                    <span class="input-group-text cursor-pointer"
                                        onclick="togglePassword('password', this)">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                    @error('password')
                                        <span id="password-error" class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                            </div>
                            <div class="col-xl-12 text-center">
                                    <button type="submit" class="btn btn-dark fw-semibold">
                                        {{ __('Signin') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection