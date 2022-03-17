@extends('layouts.app')

@section('content')

<div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('assets/images/backgrounds/login-bg.jpg')">
    <div class="container">
        <div class="form-box">
            <h2>Masuk</h2>
            <p>Ayo masuk dan lanjut berbelanja!</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- End .form-group -->

                <div class="form-group">
                    <label for="singin-password-2">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="singin-password-2" name="password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- End .form-group -->
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="signin-remember-2">Remember Me</label>
                </div><!-- End .custom-checkbox -->
                <div class="form-footer justify-content-between">
                    <button type="submit" class="btn btn-outline-primary-2">
                        <span>LOG IN</span>
                        <i class="icon-long-arrow-right"></i>
                    </button>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                    @endif
                </div><!-- End .form-footer -->
                <div class="my-2">
                    Belum ada akun ? <a href="{{route('register')}}">Daftar Akun</a>
                </div>
            </form>
            <hr>
            <div class="form-choice mt-1">
                <p class="text-center">or</p>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{url('auth/redirect')}}" class="btn btn-login btn-g">
                            <i class="icon-google"></i>
                            Login With Google
                        </a>
                    </div><!-- End .col-6 -->
                </div><!-- End .row -->

        </div><!-- End .form-box -->
    </div><!-- End .container -->
</div><!-- End .login-page section-bg -->
@endsection
