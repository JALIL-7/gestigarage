<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestiGarage — Connexion Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0d0f14;
            --bg-card: #181c24;
            --border: #252b3a;
            --accent: #f97316;
            --text-primary: #e8eaf0;
            --text-secondary: #8892a4;
            --danger: #ef4444;
            --radius: 12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg-dark); 
            color: var(--text-primary); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center;
            background-image: radial-gradient(circle at top, rgba(249,115,22,0.1), transparent 40%),
                              radial-gradient(circle at bottom right, rgba(139,92,246,0.05), transparent 40%);
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--accent), #ea580c);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 16px rgba(249,115,22,0.25);
        }
        .auth-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 6px; }
        .auth-subtitle { color: var(--text-secondary); font-size: 0.9rem; }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control {
            width: 100%; padding: 12px 14px; border-radius: 8px;
            background: rgba(255,255,255,0.04); border: 1px solid var(--border);
            color: var(--text-primary); font-size: 0.95rem; transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .form-control:focus { outline: none; border-color: var(--accent); background: rgba(249,115,22,0.06); }

        .btn-primary {
            width: 100%;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 20px; border-radius: 8px; border: none;
            background: var(--accent); color: white;
            font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(249,115,22,0.3);
        }
        .btn-primary:hover { background: #ea580c; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(249,115,22,0.4); }

        .alert-danger {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.3);
            color: var(--danger);
            padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }

        .toggle-group {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.85rem; color: var(--text-secondary); cursor: pointer;
        }
        .toggle-group input { accent-color: var(--accent); cursor: pointer; width: 16px; height: 16px; }

    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <div class="logo-icon"><i class="bi bi-wrench-adjustable-circle-fill" style="color:white;font-size:26px;"></i></div>
        <div class="auth-title">Administration</div>
        <div class="auth-subtitle">Connectez-vous pour accéder au portail</div>
    </div>

    <div class="card">
        @if($errors->any())
            <div class="alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Adresse email</label>
                <div style="position:relative;">
                    <i class="bi bi-envelope" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-secondary);"></i>
                    <input type="email" name="email" class="form-control" placeholder="admin@gestigarage.com" value="{{ old('email') }}" required autofocus style="padding-left:42px;">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div style="position:relative;">
                    <i class="bi bi-lock" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-secondary);"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required style="padding-left:42px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="toggle-group">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Se souvenir de moi</span>
                </label>
            </div>

            <button type="submit" class="btn-primary">
                Se connecter <i class="bi bi-box-arrow-in-right"></i>
            </button>
        </form>
    </div>
    
    <div style="text-align:center; margin-top:30px; font-size:0.85rem; color:var(--text-secondary);">
        <a href="{{ route('welcome') }}" style="color:var(--text-secondary); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:color 0.2s;" onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-secondary)'">
            <i class="bi bi-arrow-left"></i> Retour au site public
        </a>
    </div>
</div>

</body>
</html>
