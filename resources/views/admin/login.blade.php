<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
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
        <h2>Admin Login</h2>
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <div style="position: relative;">
                <input type="password" id="password" placeholder="Password" required>

                <!-- Ikon Mata -->
                <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ccc" viewBox="0 0 576 512">
                        <path d="M572.52 241.4C518.86 135.45 407.38 64 288 64S57.14 135.45 3.48 241.4a48.06 48.06 0 0 0 0 29.2C57.14 376.55 168.62 448 288 448s230.86-71.45 284.52-177.4a48.06 48.06 0 0 0 0-29.2zM288 400c-97.05 0-187.59-57.78-240-144 52.41-86.22 142.95-144 240-144s187.59 57.78 240 144c-52.41 86.22-142.95 144-240 144zm0-240a96 96 0 1 0 96 96 96.11 96.11 0 0 0-96-96zm0 144a48 48 0 1 1 48-48 48.05 48.05 0 0 1-48 48z"/>
                    </svg>

                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ccc" viewBox="0 0 640 512" style="display: none;">
                        <path d="M320 400c-46.54 0-89.2-16.9-121.89-44.71l-73.54 57.25a16 16 0 0 1-22.63-2.57l-9.38-11.71a16 16 0 0 1 2.57-22.63l77.84-60.55C152.5 291.36 144 260.74 144 224a176 176 0 0 1 316.52-106.55L617 2.6A16 16 0 0 1 639.4 22.6L20.6 489.4A16 16 0 0 1 .6 467.4l36.4-45.1A271.7 271.7 0 0 1 0 256c58.65-101.44 163.59-168 288-168a285.25 285.25 0 0 1 112.9 23.1l-42.37 34a144 144 0 0 0-70.53-17.1c-79.53 0-144 64.47-144 144 0 32.43 11.34 62.33 30.23 86.25L84.43 426.76a16 16 0 0 1-22.63-2.57l-9.38-11.71a16 16 0 0 1 2.57-22.63l254.34-198.08A144.13 144.13 0 0 0 320 400z"/>
                    </svg>
                </span>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const eyeOpen = document.getElementById("eyeOpen");
        const eyeClosed = document.getElementById("eyeClosed");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "inline";
        } else {
            passwordInput.type = "password";
            eyeOpen.style.display = "inline";
            eyeClosed.style.display = "none";
        }
    }
</script>



</body>
</html>
