@extends('layouts.app')

@section('content')

<div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('assets/images/backgrounds/login-bg.jpg')">
    <div class="container">
        <div class="form-box">
            <h2>Jadilah bagian dari kami !</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Anda *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- End .form-group -->

                <div class="form-group">
                    <label for="phone">No.HP / Whatsapp *</label>
                    <div>
                        <input id="phone" type="tel" class="form-control no-arrow @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                    </div>
                    <small class="d-block">Untuk berbicara tentang pesanan anda.</small>

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- End .form-group -->

                <div class="form-group">
                    <label for="email">Email address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <small class="d-block">Sebagai penerima invoice / notifikasi pesanan anda.</small>
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

                <div class="form-group">
                    <label for="confirm-password">Confirm Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="confirm-password" name="password_confirmation" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><!-- End .form-group -->

                <div class="form-footer justify-content-between">
                    <button type="submit" class="btn btn-outline-primary-2">
                        <span>Daftar</span>
                        <i class="icon-long-arrow-right"></i>
                    </button>
                </div><!-- End .form-footer -->
                <div class="my-2">
                    Sudah memiliki akun ? <a href="{{route('login')}}">Masuk</a>
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
@push('script')
<script>
    //Input Telp International
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        initialCountry:"id",
        preferredCountries: ['id', 'us', 'my','sg','ph'],
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/utils.js",
    });

    // store the instance variable so we can access it in the console e.g. window.iti.getNumber()
    window.iti = iti;
</script>
@endpush
@endsection
