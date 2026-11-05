<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — LaundryKuy</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at 30% 20%, #14b8a6 0%, #0f766e 55%, #134e4a 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-card {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(6px);
            border-radius: 1.1rem;
            border: 1px solid rgba(255,255,255,.6);
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
            max-width: 420px; width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="display-3">🧺</div>
            <h1 class="h3 fw-bold mb-1">LaundryKuy</h1>
            <p class="text-muted mb-0">Masuk untuk mengelola pelanggan, layanan &amp; transaksi.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.authenticate') }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="user_name" class="form-label">Username</label>
                <input type="text" name="user_name" id="user_name" class="form-control form-control-lg"
                       value="{{ old('user_name') }}" placeholder="admin" autofocus required autocomplete="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-lg"
                       placeholder="••••••••" required autocomplete="current-password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background:#0f766e;border-color:#0f766e;color:#fff">Masuk</button>
            </div>
        </form>

        <div class="text-center small text-muted mt-3">
            <code>admin / admin123</code> (akun latihan)
        </div>
    </div>
</body>
</html>
