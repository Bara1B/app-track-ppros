@extends('layouts.auth')

@section('content')
    <div class="auth-full-bg">
        {{-- GLOBAL BACK BUTTON TOP-LEFT --}}
        <div class="global-back-btn">
            <a href="{{ route('public.home') }}" class="btn btn-gradient-back d-inline-flex align-items-center" style="gap:.5rem" aria-label="Kembali ke halaman publik">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                <span class="back-label">Kembali</span>
            </a>
        </div>
        {{-- BRANDING DI BACKGROUND (KIRI) --}}
        <div class="auth-branding text-white text-center d-none d-md-flex flex-column align-items-center justify-content-center position-relative">
            <div class="branding-inner">
                <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros Logo" class="branding-logo mb-3">
                <h1 class="branding-title fw-bold mb-2">Sistem SO & Tracking WO</h1>
                <p class="lead mb-3">Tingkatkan efisiensi operasional dan kualitas layanan secara terpadu.</p>
                <div class="branding-chips d-flex flex-wrap justify-content-center gap-2">
                    <span class="chip">Real-time Tracking</span>
                    <span class="chip">Integrasi Mulus</span>
                    <span class="chip">Analitik Cerdas</span>
                </div>
            </div>
            {{-- Accents --}}
            <span class="orb orb-1"></span>
            <span class="orb orb-2"></span>
            <span class="orb orb-3"></span>
        </div>

    <style>
        .btn-gradient-back {
            color: #fff;
            border: 1.25px solid rgba(255, 255, 255, 0.45);
            border-radius: 9999px;
            padding: .5rem .95rem;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: saturate(130%) blur(6px);
            -webkit-backdrop-filter: saturate(130%) blur(6px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18), inset 0 1px 0 rgba(255,255,255,0.25);
            transition: transform .15s ease, box-shadow .2s ease, filter .2s ease, background .2s ease, color .2s ease, border-color .2s ease;
        }
        .btn-gradient-back:hover {
            background: linear-gradient(90deg, rgba(255,255,255,0.22), rgba(255,255,255,0.1));
            border-color: rgba(255, 255, 255, 0.6);
            filter: brightness(1.05);
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.28);
            transform: translateY(-1px);
        }
        .btn-gradient-back:active {
            transform: translateY(0);
            filter: brightness(0.98);
        }
        .btn-gradient-back:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.35), 0 8px 20px rgba(0,0,0,0.25);
        }

        .btn-login-gradient {
            color: #fff;
            font-weight: 600;
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: .85rem 1.1rem;
            background-image: linear-gradient(90deg, #1e3a8a, #1d4ed8, #2563eb, #3b82f6);
            background-size: 200% 100%;
            background-position: left center;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.35);
            transition: transform .15s ease, box-shadow .2s ease, filter .2s ease, background-position .35s ease;
        }
        .btn-login-gradient:hover {
            filter: brightness(1.04);
            background-position: right center;
            box-shadow: 0 16px 34px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }
        .btn-login-gradient:active {
            transform: translateY(0);
            filter: brightness(0.98);
        }
    </style>

        {{-- FORM LOGIN --}}
        <div class="login-full-wrapper" style="position: relative;">
            <div class="col-md-10 col-lg-7 ms-auto me-auto">
                <div class="card login-card p-4">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center mb-3">
                            <img src="{{ asset('images/logoPhapros.png') }}" alt="Phapros" style="height:34px; filter: brightness(0.1) contrast(1.1);" class="mb-2">
                            <h4 class="card-title mb-1 fw-bold text-center">Masuk ke Akun Anda</h4>
                            <p class="text-muted mb-0 text-center">Silakan login untuk melanjutkan proses</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="text-start" aria-describedby="login-help">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>Terjadi kesalahan.</strong> Periksa kembali input Anda.
                                </div>
                            @endif
                            <div class="mb-3 position-relative">
                                <label for="email" class="form-label fw-medium">Alamat Email</label>
                                <div class="input-with-icon">
                                    <span class="form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" opacity="0"/><path d="M4 4h16v16H4z" opacity="0"/><path d="M4 4h16v16H4z" opacity="0"/><path d="M4 4h16v16H4z" opacity="0"/><path d="M4 4h16v16H4z" opacity="0"/><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                                    </span>
                                    <input id="email" type="email" class="form-control ps-5 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-invalid="@error('email') true @else false @enderror" aria-describedby="emailHelp @error('email') emailError @enderror">
                                </div>
                                @error('email')
                                    <span id="emailError" class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-2 position-relative">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-with-icon">
                                    <span class="form-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 11c0-1.1.9-2 2-2s2 .9 2 2"/><path d="M4 11V7a4 4 0 0 1 8 0v4"/><rect x="4" y="11" width="16" height="9" rx="2"/></svg>
                                    </span>
                                    <input id="password" type="password" class="form-control ps-5 pe-5 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" aria-invalid="@error('password') true @else false @enderror" aria-describedby="passwordHelp @error('password') passwordError @enderror">
                                    <button type="button" class="password-toggle" aria-label="Tampilkan password" onclick="(function(btn){const i=document.getElementById('password'); if(!i) return; const isP=i.type==='password'; i.type=isP?'text':'password'; btn.setAttribute('aria-label', isP?'Sembunyikan password':'Tampilkan password');})(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                </div>
                                @error('password')
                                    <span id="passwordError" class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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
                                <button type="submit" class="btn btn-login-gradient d-inline-flex align-items-center justify-content-center gap-2">
                                    Login
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                                {{-- Register link hidden per requirement --}}
                            </div>

                            <div class="text-center mt-3" id="login-help">
                                <small class="text-muted">Butuh akses? Hubungi administrator.</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
