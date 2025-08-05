<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Superadmin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            margin: 0;
            background: linear-gradient(to bottom, #111, #333);
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 0;
            box-shadow: 0 0 15px #ffffff55;
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
        }

        .login-box .password-wrapper {
            position: relative;
        }

        .login-box .toggle-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        .login-box button {
            width: 100%;
            background: #ffffff;
            color: #111;
            border: none;
            padding: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            color: #ff6b6b;
            text-align: center;
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf
            <input type="text" name="username" placeholder="Username" required>

            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" required id="password">
                <span class="toggle-icon" id="togglePassword">
                    <i data-feather="eye" id="iconPassword"></i>
                </span>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace(); // Render semua ikon pertama kali

        const toggle = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        toggle.addEventListener('click', function () {
            const iconContainer = toggle; // tombol <span> atau <button>
            const isPassword = passwordInput.type === 'password';

            // Ubah tipe input
            passwordInput.type = isPassword ? 'text' : 'password';

            // Hapus isi ikon lama
            iconContainer.innerHTML = '';

            // Tambahkan ikon baru sesuai status
            const newIcon = document.createElement('i');
            newIcon.setAttribute('data-feather', isPassword ? 'eye-off' : 'eye');
            newIcon.id = 'iconPassword';
            iconContainer.appendChild(newIcon);

            // Render ulang Feather Icon
            feather.replace();
        });
    });
</script>


</body>
</html>
