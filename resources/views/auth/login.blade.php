<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Orvélo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            var(--orvelo-teal): #0f2929; 
            --orvelo-light: #1a4242;
        }

        body {
            background: radial-gradient(circle at 50% 0%, var(--orvelo-light) 0%, #0f2929 80%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        /* --- Kartu Kaca (Glassmorphism) --- */
        .glass-login {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.03) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            border-left: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 3.5rem 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(255, 255, 255, 0.08), 0 25px 60px rgba(0, 0, 0, 0.4);
            color: white;
        }

        /* --- Logo & Tagline --- */
        .logo-text {
            font-weight: 800;
            font-size: 3rem;
            letter-spacing: -1.5px;
            text-align: center;
            margin-bottom: 0.2rem;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .tagline {
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.95rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
        }

        /* --- Input Minimalis --- */
        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.3rem;
        }

        .input-minimal {
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0;
            background: transparent !important;
            padding-left: 0;
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
            box-shadow: none !important;
            position: relative;
            z-index: 1;
        }
        .input-minimal:focus {
            border-bottom-color: #ffffff;
        }
        .input-minimal::placeholder {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.95rem;
            font-weight: 400;
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px transparent inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* --- Tombol Mata (DIPERBAIKI) --- */
        .btn-eye {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0;
            color: rgba(255, 255, 255, 0.5);
            transition: 0.3s;
            padding-right: 0;
            z-index: 10; /* Memastikan tombol mata berada paling depan */
            cursor: pointer;
        }
        .btn-eye:hover { color: white; }
        .password-group:focus-within .input-minimal,
        .password-group:focus-within .btn-eye {
            border-bottom-color: #ffffff;
        }

        /* --- Tombol Login --- */
        .btn-login {
            background-color: #ffffff;
            color: #0f2929;
            border-radius: 50px;
            padding: 0.9rem;
            font-weight: 800;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 2rem;
            transition: 0.3s;
            border: none;
            box-shadow: 0 4px 15px rgba(255,255,255,0.1);
        }
        .btn-login:hover {
            background-color: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

    <div class="glass-login">
        
        <div class="logo-text">orvélo.</div>
        <p class="tagline">Sign in to elevate your stride.</p>

        @if ($errors->any())
            <div class="alert rounded-3 border-0 py-2 px-3 shadow-sm mb-4" style="font-size: 0.85rem; background-color: rgba(220, 53, 69, 0.9); color: white;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf 
            
            <div class="mb-4">
                <label class="form-label-custom">Email</label>
                <input type="email" name="email" class="form-control form-control-lg input-minimal" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label-custom">Password</label>
                <div class="input-group password-group">
                    <input type="password" id="passwordInput" name="password" class="form-control form-control-lg input-minimal" placeholder="Enter your password" required>
                    <!-- Tombol mata diberi style cursor agar jelas bisa diklik -->
                    <button type="button" class="btn btn-eye" id="togglePassword" title="Lihat Password">
                        <i class="bi bi-eye-slash fs-5" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>

    <!-- JavaScript Tombol Mata (DIPERBAIKI) -->
    <script>
        // Memastikan seluruh HTML selesai dimuat sebelum menjalankan klik
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function (e) {
                    // Mencegah form tersubmit secara tidak sengaja
                    e.preventDefault();
                    
                    // Toggle tipe input
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.remove('bi-eye-slash');
                        eyeIcon.classList.add('bi-eye');
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.remove('bi-eye');
                        eyeIcon.classList.add('bi-eye-slash');
                    }
                });
            }
        });
    </script>
</body>
</html>