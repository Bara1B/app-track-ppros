@extends('layouts.auth')

@section('content')
    <div class="split-screen-container">
        {{-- SISI KIRI: BRANDING & GAMBAR --}}
        <div class="split-screen-left">
            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="split-screen-logo"
                style="filter: brightness(0) invert(1);">
            <h1 class="fw-bold mb-3">Sistem Pelacakan Work Order</h1>
            <p class="lead">Meningkatkan efisiensi dan kualitas untuk masa depan yang lebih sehat.</p>
        </div>

        {{-- SISI KANAN: FORM LOGIN --}}
        <div class="split-screen-right">
            <div class="col-md-8 col-lg-7">
                <div class="card login-card p-4">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-1 fw-bold">Selamat Datang!</h4>
                        <p class="text-muted mb-4">Silakan masuk untuk melanjutkan</p>

                        <form method="POST" action="{{ route('login') }}" class="text-start">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Alamat Email</label>
                                <input id="email" type="email"
                                    class="form-control p-2 @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input id="password" type="password"
                                    class="form-control p-2 @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-sm" href="{{ route('password.request') }}">Lupa Password?</a>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-phapros">Login</button>
                                {{-- ================================================ --}}
                                {{--    LINK BARU DITAMBAHIN DI SINI, BRO           --}}
                                {{-- ================================================ --}}
                                @if (Route::has('register'))
                                    <div class="text-center mt-3">
                                        <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}"><b>Daftar
                                                    di sini</b></a></p>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
