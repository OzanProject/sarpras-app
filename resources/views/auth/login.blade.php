<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - {{ $global_settings['nama_sekolah'] ?? 'Sarana Prasarana' }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="{{ (isset($global_settings['logo']) && $global_settings['logo']) ? asset('storage/' . $global_settings['logo']) : asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('darkpan/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('darkpan/css/style.css') }}" rel="stylesheet">
    
    <!-- Override Stylesheet -->
    <link href="{{ asset('darkpan/css/sarpras-override.css') }}" rel="stylesheet">

    <!-- Inline Auth Styles (Bypasses Browser Caching) -->
    <style>
        .auth-bg {
            background: radial-gradient(circle at 10% 20%, rgba(14, 165, 233, 0.08) 0%, transparent 45%), 
                        radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.08) 0%, transparent 45%), 
                        #f8fafc !important;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(14, 165, 233, 0.12) !important;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(14, 165, 233, 0.04) !important;
            border-radius: 24px !important;
            padding: 2.5rem !important;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .auth-card:hover {
            box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(14, 165, 233, 0.06) !important;
        }

        .auth-logo-frame {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 2px solid #bae6fd;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(14, 165, 233, 0.08);
            transition: all 0.3s ease;
            margin: 0 auto;
        }

        .auth-title-text {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .auth-input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            z-index: 10;
        }

        .auth-field {
            padding-left: 46px !important;
            border-radius: 12px !important;
            border: 1.5px solid #cbd5e1 !important;
            height: auto !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
        }

        .auth-field:focus {
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12) !important;
        }

        .auth-field:focus + .auth-input-icon {
            color: #0ea5e9;
        }

        .auth-toggle-pass {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            background: none;
            border: none;
            padding: 0;
            z-index: 10;
        }

        .auth-btn-submit {
            background: linear-gradient(135deg, #0ea5e9, #0284c7) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            padding: 12px 24px !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .auth-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.25) !important;
            background: linear-gradient(135deg, #0284c7, #0369a1) !important;
            color: #ffffff !important;
        }
    </style>
</head>

<body class="auth-bg">
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="auth-card my-4 mx-3">
                        <div class="auth-logo-container text-center mb-4">
                            <div class="auth-logo-frame">
                                @if(isset($global_settings['logo']) && $global_settings['logo'])
                                    <img src="{{ asset('storage/' . $global_settings['logo']) }}" alt="Logo" style="width: 36px; height: 36px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <i class="fa fa-school"></i>
                                @endif
                            </div>
                            <h3 class="auth-title-text mt-3 mb-1">{{ $global_settings['nama_sekolah'] ?? 'SARPRAS' }}</h3>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Selamat Datang! Silakan masuk ke akun Anda</p>
                        </div>
                        
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert" style="border-radius: 12px; font-size: 0.85rem;">
                                <i class="fa fa-check-circle me-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" style="border-radius: 12px; font-size: 0.85rem;">
                                <div class="fw-semibold mb-1"><i class="fa fa-exclamation-circle me-2"></i>Kesalahan:</div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="auth-input-group">
                                <input type="email" class="form-control auth-field" id="email" name="email" placeholder="Alamat email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                <i class="fa fa-envelope auth-input-icon"></i>
                            </div>
                            
                            <div class="auth-input-group">
                                <input type="password" class="form-control auth-field" id="password" name="password" placeholder="Kata sandi" required autocomplete="current-password">
                                <i class="fa fa-lock auth-input-icon"></i>
                                <button type="button" class="auth-toggle-pass" id="btn-toggle-password" onclick="togglePasswordVisibility('password', 'toggle-icon-pass')">
                                    <i class="fa fa-eye" id="toggle-icon-pass"></i>
                                </button>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember" style="cursor: pointer;">
                                    <label class="form-check-label text-muted" for="remember_me" style="font-size: 0.85rem; cursor: pointer; user-select: none;">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #0ea5e9; font-size: 0.85rem; font-weight: 600;">Lupa Password?</a>
                                @endif
                            </div>
                            
                            <button type="submit" class="btn btn-primary auth-btn-submit py-3 mb-4">
                                Masuk <i class="fa fa-sign-in-alt ms-1"></i>
                            </button>
                            
                            <p class="text-center mb-0 text-muted" style="font-size: 0.875rem;">
                                Belum punya akun? <a href="{{ route('register') }}" style="color: #0ea5e9; font-weight: 600; text-decoration: none;">Daftar Disini</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('darkpan/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('darkpan/lib/waypoints/waypoints.min.js') }}"></script>
    
    <!-- Template Javascript -->
    <script src="{{ asset('darkpan/js/main.js') }}"></script>

    <!-- Password Visibility Toggle Script -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
