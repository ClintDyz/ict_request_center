<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ICT Request Center – Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", "Segoe UI", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            background: #001a3e;
        }

        /* ------------------------------
            NAVBAR FIXED STYLE
        ------------------------------ */
        .navbar-custom {
            backdrop-filter: blur(6px);
            background: rgba(255, 255, 255, 0.05) !important;
            padding: 15px 40px !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        .navbar-brand {
            font-size: 1.2rem;
            color: #ffffff !important;
            font-weight: 600;
            letter-spacing: .3px;
        }

        .navbar-brand i {
            color: #ffffff;
            margin-right: 6px;
        }

        .btn-create {
            background: #2563EB;
            border: none;
            padding: 8px 16px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-create:hover {
            opacity: 0.9;
        }

        /* ----------------------------------------------------------
            BACKGROUND ANIMATION (unchanged)
        ---------------------------------------------------------- */

        .gradient-bg {
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 30%, rgba(0,128,255,0.4), transparent 60%),
                        radial-gradient(circle at 80% 70%, rgba(0,255,188,0.35), transparent 60%),
                        radial-gradient(circle at 40% 90%, rgba(0,102,255,0.4), transparent 60%);
            animation: gradientMove 40s ease-in-out infinite alternate;
            z-index: 1;
        }

        @keyframes gradientMove {
            0%   { transform: translate(-10%, -10%) scale(1); }
            50%  { transform: translate(-5%, -20%) scale(1.1); }
            100% { transform: translate(0%, -10%) scale(1); }
        }

        .particles span {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255,255,255,0.45);
            border-radius: 50%;
            animation: floatUp 12s linear infinite;
            filter: blur(1px);
        }

        @keyframes floatUp {
            0% { transform: translateY(120vh) scale(0.6); opacity: 0; }
            40% { opacity: .9; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        .particles span:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particles span:nth-child(2) { left: 30%; animation-delay: 2s; }
        .particles span:nth-child(3) { left: 50%; animation-delay: 4s; }
        .particles span:nth-child(4) { left: 70%; animation-delay: 1s; }
        .particles span:nth-child(5) { left: 90%; animation-delay: 3s; }

        .login-container {
            width: 900px;
            background: #ffffff;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0px 20px 60px rgba(0,0,0,0.35);
            position: relative;
            z-index: 3;
            margin-top: 80px; /* pushes card down so navbar doesn't overlap */
        }

        .left-panel {
            width: 50%;
            background: linear-gradient(145deg, #0A1A33, #16476A);
            color: white;
            padding: 60px 30px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel img {
            width: 120px;
            align-self: center;
            filter: drop-shadow(0 0 10px rgba(255,255,255,0.2));
        }

        .left-panel h2 {
            font-weight: 700;
            font-size: 22px;
            margin-top: 20px;
            line-height: 1.5;
        }

        .right-panel {
            width: 60%;
            padding: 50px;
            background: #fff;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #4b8bff;
            box-shadow: 0 0 0 3px rgba(78, 138, 255, 0.25);
        }

        .btn-login {
            background: linear-gradient(90deg, #0046FF, #0CC6FF);
            border: none;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-login:hover {
            opacity: 0.92;
        }

        .small-text {
            font-size: 12px;
            color: #777;
        }

    </style>
</head>

<body>

<!-- FIXED GLASS NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid">

        {{-- <a class="navbar-brand" href="#">
            <i class="fa-solid fa-star"></i> SMS Accreditation
        </a> --}}

        <div class="ms-auto">
            <a href="{{ route('resource_speaker.create') }}" class="btn btn-create text-white">
                <i class="fa-solid fa-user me-1"></i> RS
            </a>
        </div>

    </div>
</nav>

<!-- Background Animation Elements -->
<div class="gradient-bg"></div>

<div class="particles">
    <span></span><span></span><span></span><span></span><span></span>
</div>

<!-- LOGIN CARD -->
<div class="login-container">

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <img src="{{ asset('img/DOST-CAR.png') }}" alt="Logo">
        <h2>Subject Matter Specialist<br>Accreditation System</h2>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <h3 class="fw-bold mb-2">Welcome Back</h3>
        <p class="text-muted mb-4">Enter your credentials to access your account</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" name="username"
                        class="form-control border-start-0 @error('username') is-invalid @enderror"
                        placeholder="Enter your username" autofocus>
                </div>
                @error('username')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" name="password"
                        class="form-control border-start-0 @error('password') is-invalid @enderror"
                        placeholder="Enter your password">
                </div>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-login w-100 text-white">
                <i class="fa fa-sign-in-alt me-2"></i> Log In
            </button>

            <p class="text-center small-text mt-4">
                Developed by DOST–CAR MS Unit
            </p>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
