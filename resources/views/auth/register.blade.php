@extends('layouts.auth')

@section('content')
    <div class="split-screen-container">
        {{-- SISI KIRI: BRANDING & GAMBAR --}}
        <div class="split-screen-left">
            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="split-screen-logo"
                style="filter: brightness(0) invert(1);">
            <h1 class="fw-bold mb-3">Sistem SO Dan Tracking WO</h1>
            <p class="lead">Meningkatkan efisiensi dan kualitas untuk masa depan yang lebih sehat.</p>
        </div>

        {{-- SISI KANAN: FORM REGISTER --}}
        <div class="split-screen-right">
            <div class="col-md-8 col-lg-7">
                <div class="card login-card p-4">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-1 fw-bold">Buat Akun Baru</h4>
                        <p class="text-muted mb-4">Daftar untuk mulai melacak work order</p>

                        <form method="POST" action="{{ route('register') }}" class="text-start">
                            @csrf
                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                                <input id="name" type="text"
                                    class="form-control p-2 @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Alamat Email</label>
                                <input id="email" type="email"
                                    class="form-control p-2 @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input id="password" type="password"
                                    class="form-control p-2 @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label fw-medium">Konfirmasi Password</label>
                                <input id="password-confirm" type="password" class="form-control p-2"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-phapros">Daftar</button>
                            </div>

                            <div class="text-center mt-3">
                                <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}"><b>Login di
                                            sini</b></a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
