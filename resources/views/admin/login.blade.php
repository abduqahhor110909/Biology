<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kirish - BioSfera Biologiya Portali</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 10% 20%, #ecfdf5 0%, #f0fdf4 40%, #ffffff 90%);
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid #d1fae5;
            border-radius: 24px;
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.2);
            width: 100%;
            max-width: 440px;
            padding: 42px;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .brand-emblem {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #10b981, #047857);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
            margin-bottom: 12px;
        }
        .demo-hint {
            background: #f0fdf4;
            border: 1px dashed #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            color: #166534;
            margin-bottom: 22px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <div class="brand-emblem">
                <i class="bi bi-flower1"></i>
            </div>
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #065f46;">BioSfera Admin</h2>
            <p style="color: #64748b; font-size: 0.9rem;">Boshqaruv paneliga kirish</p>
        </div>

        <div class="demo-hint">
            <strong>Login ma'lumotlari:</strong><br>
            Email: <code>admin@biology.uz</code><br>
            Parol: <code>admin123</code>
        </div>

        @if($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 10px 14px; border-radius: 10px; margin-bottom: 20px; font-size: 0.88rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email manzili</label>
                <input type="email" name="email" value="{{ old('email', 'admin@biology.uz') }}" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Parol</label>
                <input type="password" name="password" value="admin123" class="form-control" required>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; font-size: 0.88rem;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #475569;">
                    <input type="checkbox" name="remember" checked> Meni eslab qol
                </label>
                <a href="{{ route('home') }}" style="color: #059669; font-weight: 600;">Saytga qaytish</a>
            </div>

            <button type="submit" class="form-btn-submit">
                Tizimga kirish <i class="bi bi-box-arrow-in-right" style="margin-left: 6px;"></i>
            </button>
        </form>
    </div>
</body>
</html>
