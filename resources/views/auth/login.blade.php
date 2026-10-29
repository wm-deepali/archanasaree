@extends('layouts.admin-app')

@section('content')

    <style>
        /* =====================================================
           ARCHANA SAREE EMPORIUM - THEME VARIABLES
           Sirf yahin se poori login theme control hoti hai.
           --aw-primary ki value site ke :root (--primary) se match kar do.
           ===================================================== */
        :root {
            --aw-primary: #B08D57;
            /* TODO: site ke --primary ki asli hex yahan daalo */
            --aw-bg: #FAF6EE;
            /* site ka cream background (home.css overlay se confirmed) */
            --aw-black: #0A0806;
            /* site ka dark tone (home.css overlay se) */
            --aw-white: #FFFFFF;
            --aw-line: rgba(0, 0, 0, 0.12);
            /* site ke divider lines */
        }

        body {
            background: var(--aw-bg);
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 950px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            background: var(--aw-white);
        }

        .logo-box {
            background: var(--aw-white);
            padding: 15px;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .logo-box img {
            width: 140px;
            height: auto;
            max-height: 90px;
            object-fit: contain;
        }

        .login-left {
            position: relative;
            width: 45%;
            background: linear-gradient(135deg, #63364d, #63364d);
            color: var(--aw-white);
            text-align: center;
            padding: 40px 20px;
        }

        /* site jaisa thin inset border */
        .login-left::after {
            content: "";
            position: absolute;
            inset: 16px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            pointer-events: none;
        }

        .login-left img {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-left h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 14px;
            opacity: 0.9;
        }

        .login-right {
            width: 55%;
            padding: 40px;
        }

        .login-title {
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--aw-black);
        }

        .login-right label {
            color: var(--aw-black);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            background: var(--aw-bg);
            border: 1px solid var(--aw-line);
        }

        .form-control:focus {
            box-shadow: none;
            border: 1px solid var(--aw-primary);
            background: var(--aw-white);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: #63364d;
            color: var(--aw-white);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #b888a1;
            color: var(--aw-white);
        }

        .form-check-label {
            font-size: 14px;
        }

        .form-check-input:checked {
            background-color: var(--aw-primary);
            border-color: var(--aw-primary);
        }

        .forgot-link {
            font-size: 14px;
            text-decoration: none;
            color: var(--aw-primary);
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
            }

            .login-left {
                background: linear-gradient(135deg, var(--aw-black), var(--aw-black));
            }
        }
    </style>

    @php
        $loginLogo = $general?->admin_login_logo;
        $siteName = $general?->site_name ?? 'Archana Saree Emporium';
        $tagline = $general?->tagline ?? 'Premium Sarees · Designer Lehengas · Bridal Wear';
    @endphp

    <div class="login-wrapper">
        <div class="login-card">

            <!-- LEFT SIDE -->
            <div class="login-left">

                <div class="logo-box">
                    <!--  @if($loginLogo)
                <img src="{{ asset('storage/' . $loginLogo) }}" alt="{{ $siteName }}">
            @else

            @endif -->
                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $siteName }}">
                </div>

                <h2>{{ $siteName }}</h2>
                <p>{{ $tagline }}</p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="login-right">
                <h4 class="login-title">Admin Login</h4>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>

                        @error('password')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- REMEMBER -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Remember Me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="btn btn-login">
                        Login
                    </button>

                </form>
            </div>

        </div>
    </div>

@endsection