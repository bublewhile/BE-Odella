<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Odella Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(145deg, #FFFBF5 0%, #FEF7EE 100%);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            max-width: 480px;
            width: 100%;
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(134, 1, 32, 0.08), 0 0 0 1px #EADBC8;
            transition: transform 0.2s;
        }

        .login-card:hover {
            transform: translateY(-3px);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo-img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 0.8rem;
        }

        .logo h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2A1A1A;
            margin-bottom: 0.25rem;
        }

        .logo p {
            color: #8A6D6D;
            font-size: 0.85rem;
        }

        .input-group-custom {
            margin-bottom: 1.25rem;
        }

        .input-group-custom label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #5E3A2E;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #B89090;
            z-index: 2;
        }

        .input-icon input {
            width: 100%;
            padding: 0.8rem 2.5rem 0.8rem 2.8rem;
            border: 1px solid #EADBC8;
            border-radius: 1.5rem;
            font-size: 0.9rem;
            background: #FFFCF8;
            transition: all 0.2s;
        }

        .input-icon input:focus {
            outline: none;
            border-color: #860120;
            box-shadow: 0 0 0 3px rgba(134, 1, 32, 0.1);
            background: white;
        }

        .toggle-pwd {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #B89090;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            width: 24px;
            height: 24px;
        }

        .btn-login {
            background: #860120;
            border: none;
            width: 100%;
            padding: 0.8rem;
            border-radius: 2rem;
            font-weight: 600;
            color: white;
            transition: 0.2s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            background: #5E0118;
            transform: scale(1.01);
            box-shadow: 0 8px 16px rgba(134, 1, 32, 0.15);
        }

        .footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.7rem;
            color: #B9A4A4;
        }

        .alert-custom {
            background: #FFF1F1;
            border-left: 4px solid #860120;
            border-radius: 1rem;
            padding: 0.7rem 1rem;
            font-size: 0.8rem;
            color: #B42318;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 500px) {
            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('storage/images/odella_logo.png') }}" alt="Odella Bakery" class="logo-img">
            <p>Admin Dashboard</p>
        </div>

        @if (session('error'))
            <div class="alert-custom">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="input-group-custom">
                <label>Email</label>
                <div class="input-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" placeholder="admin@odellabakery.com" required autofocus>
                </div>
            </div>

            <div class="input-group-custom">
                <label>Password</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-pwd" onclick="togglePassword()">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
            </button>
        </form>

        <div class="footer">
            &copy; {{ date('Y') }} Odella Bakery — <a href="#"
                style="color:#860120; text-decoration:none;">Hubungi Admin</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.remove('bi-eye-slash');
                eye.classList.add('bi-eye');
            } else {
                pwd.type = 'password';
                eye.classList.remove('bi-eye');
                eye.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>

</html>
