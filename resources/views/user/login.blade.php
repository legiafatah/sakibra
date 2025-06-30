<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Peserta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h2>Peserta Login</h2>
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ url('/user/login') }}">
            @csrf
            <input type="text" name="kode" placeholder="kode" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
