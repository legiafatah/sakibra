@extends('layouts.app')
@section('content')

<style>
body {
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #000000, rgba(255,255,255,0.08) 50%, #000000);
    font-family: 'Segoe UI', sans-serif;
}

    .container-home {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
        overflow: hidden;
        padding: 20px;
    }

    .flag-wave {
        width: 80px;
        height: 80px;
        background: url('https://cdn-icons-png.flaticon.com/512/3372/3372763.png') no-repeat center;
        background-size: contain;
        animation: flagWave 2s infinite ease-in-out;
        margin-bottom: 20px;
    }

    @keyframes flagWave {
        0% { transform: rotate(0deg); }
        50% { transform: rotate(10deg); }
        100% { transform: rotate(0deg); }
    }

    .title {
        font-size: 48px;
        font-weight: bold;
        margin-bottom: 10px;
        color: rgb(0, 0, 0);
        animation: fadeInDown 1s ease;
    }

    .subtitle {
        font-size: 20px;
        font-weight: 300;
        margin-bottom: 40px;
        color: #000000;
        animation: fadeInUp 1s ease;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .role-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }

    .role-buttons a {
        padding: 12px 24px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-admin {
        background-color: #ffffff;
        color: #000000;
    }

    .btn-juri {
        background-color: #555555;
        color: #ffffff;
    }

    .btn-peserta {
        background-color: #e50914;
        color: #ffffff;
    }

    .role-buttons a:hover {
        opacity: 0.9;
        transform: scale(1.08);
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 768px) {
        .title {
            font-size: 36px;
        }

        .subtitle {
            font-size: 18px;
        }

        .role-buttons a {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .flag-wave {
            width: 60px;
            height: 60px;
        }

        .title {
            font-size: 28px;
        }

        .subtitle {
            font-size: 16px;
        }
    }
</style>

<div class="container-home">
    <div class="flag-wave"></div>
    <div class="title">SAKIBRA</div>
    <div class="subtitle">“Sistem Akurasi Kejuaraan Paskibra”</div>
    <div class="role-buttons">
        <a href="{{route('admin_login')}}" class="btn-admin">Admin</a>
        <a href="{{route('juri_login')}}" class="btn-juri">Juri</a>
        <a href="{{route('user.login')}}" class="btn-peserta">Peserta</a>
    </div>
</div>

@endsection
