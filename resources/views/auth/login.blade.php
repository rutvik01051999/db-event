@extends('layouts.app')

@section('content')
    <div class="card shadow-lg">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username">

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {{-- Password with show and hide eye icon --}}
                    
                    <label for="password">
                        Password
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="{{ __('Password') }}" autocomplete="current-password">
                        <span class="input-group-text cursor-pointer"
                            onclick="togglePassword('password', this)">
                            <i class="fa fa-eye-slash"></i>
                        </span>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-md btn-primary">Sign In</button>
                </div>
            </form>
        </div>
    </div>
@endsection