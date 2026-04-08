<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'GestiGarage') — Espace Client</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg: #0b0d12;
      --bg-card: #12161f;
      --bg-card2: #181d28;
      --border: #1e2535;
      --accent: #f97316;
      --accent2: #6366f1;
      --text: #e2e8f0;
      --text-muted: #64748b;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --radius: 14px;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

    /* ── Navbar ── */
    .navbar {
      position: sticky; top: 0; z-index: 100;
      background: rgba(11,13,18,0.85); backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 32px; height: 64px;
    }
    .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .nav-logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg,var(--accent),#ea580c); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .nav-logo-text { font-weight: 800; font-size: 1.05rem; color: var(--text); }
    .nav-links { display: flex; align-items: center; gap: 8px; }
    .nav-link { padding: 8px 14px; border-radius: 8px; color: #94a3b8; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; font-weight: 500; }
    .nav-link:hover { color: var(--text); background: rgba(255,255,255,0.06); }
    .nav-link.active { color: var(--accent); }
    .nav-btn { padding: 8px 18px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; border: none; }
    .nav-btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
    .nav-btn-outline:hover { border-color: var(--accent); color: var(--accent); }
    .nav-btn-primary { background: var(--accent); color: white; }
    .nav-btn-primary:hover { background: #ea580c; }
    .nav-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,var(--accent),var(--accent2)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: white; cursor: pointer; }

    /* ── Sidebar client ── */
    .client-layout { display: flex; min-height: calc(100vh - 64px); }
    .client-sidebar {
      width: 240px; flex-shrink: 0;
      background: var(--bg-card); border-right: 1px solid var(--border);
      padding: 24px 12px; display: flex; flex-direction: column; gap: 4px;
    }
    .cs-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 12px; border-radius: 8px; text-decoration: none;
      color: var(--text-muted); font-size: 0.875rem; font-weight: 500;
      transition: all 0.2s;
    }
    .cs-item i { width: 18px; text-align: center; }
    .cs-item:hover { background: rgba(255,255,255,0.04); color: var(--text); }
    .cs-item.active { background: rgba(249,115,22,0.1); color: var(--accent); }

    /* ── Main client ── */
    .client-main { flex: 1; padding: 28px; }

    /* ── Cards ── */
    .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid var(--border); }
    .card-title { font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 8px; }

    /* ── Stats ── */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px; transition: all 0.25s; }
    .stat-card:hover { border-color: rgba(249,115,22,0.4); transform: translateY(-2px); }
    .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 10px; }
    .si-orange { background: rgba(249,115,22,0.15); color: var(--accent); }
    .si-blue   { background: rgba(99,102,241,0.15); color: var(--accent2); }
    .si-green  { background: rgba(16,185,129,0.15); color: var(--success); }
    .si-warn   { background: rgba(245,158,11,0.15); color: var(--warning); }
    .stat-val  { font-size: 1.5rem; font-weight: 800; line-height: 1; }
    .stat-label { font-size: 0.75rem; color: var(--text-muted); margin-top: 3px; }

    /* ── Table ── */
    .tbl { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
    .tbl th { padding: 9px 12px; background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border); color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
    .tbl td { padding: 11px 12px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
    .tbl tr:hover td { background: rgba(255,255,255,0.02); }

    /* ── Badge ── */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }
    .badge-success { background: rgba(16,185,129,0.15); color: var(--success); }
    .badge-warning { background: rgba(245,158,11,0.15); color: var(--warning); }
    .badge-info    { background: rgba(99,102,241,0.15); color: var(--accent2); }
    .badge-danger  { background: rgba(239,68,68,0.15);  color: var(--danger); }
    .badge-muted   { background: rgba(255,255,255,0.06); color: var(--text-muted); }

    /* ── Alert ── */
    .alert { padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: var(--success); }
    .alert-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: var(--danger); }

    /* ── Forms ── */
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: var(--text); font-size: 0.875rem; transition: all 0.2s; font-family: 'Inter',sans-serif; }
    .form-control:focus { outline: none; border-color: var(--accent); background: rgba(249,115,22,0.05); }
    textarea.form-control { resize: vertical; min-height: 100px; }

    /* ── Btn ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; border: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
    .btn-primary { background: var(--accent); color: white; }
    .btn-primary:hover { background: #ea580c; color: white; }
    .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
    .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
    .btn-sm { padding: 5px 10px; font-size: 0.78rem; }

    /* ── Status timeline ── */
    .status-steps { display: flex; align-items: center; gap: 0; margin: 20px 0; }
    .step { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
    .step::before { content:''; position:absolute; top:14px; left:-50%; width:100%; height:2px; background:var(--border); z-index:0; }
    .step:first-child::before { display:none; }
    .step-dot { width:28px; height:28px; border-radius:50%; border:2px solid var(--border); background:var(--bg-card); display:flex; align-items:center; justify-content:center; font-size:12px; z-index:1; position:relative; }
    .step.done .step-dot { border-color:var(--success); background:rgba(16,185,129,0.2); color:var(--success); }
    .step.active .step-dot { border-color:var(--accent); background:rgba(249,115,22,0.2); color:var(--accent); }
    .step-label { font-size:0.7rem; color:var(--text-muted); margin-top:6px; text-align:center; }
    .step.done .step-label, .step.active .step-label { color:var(--text); }

    /* ── Page header ── */
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; }
    .page-title { font-size:1.3rem; font-weight:800; }
    .page-subtitle { font-size:0.8rem; color:var(--text-muted); margin-top:2px; }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-track { background: transparent; } ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
  </style>
  @stack('styles')
</head>
<body>

<nav class="navbar">
  <a href="{{ route('welcome') }}" class="nav-logo">
    <div class="nav-logo-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
    <div class="nav-logo-text">GestiGarage</div>
  </a>
  <div class="nav-links">
    @auth('client')
      <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">Tableau de bord</a>
      <a href="{{ route('client.vehicules') }}" class="nav-link {{ request()->routeIs('client.vehicules*') ? 'active' : '' }}">Mes véhicules</a>
      <a href="{{ route('client.reparations') }}" class="nav-link {{ request()->routeIs('client.reparations') ? 'active' : '' }}">Réparations</a>
      <a href="{{ route('client.messages') }}" class="nav-link {{ request()->routeIs('client.messages') ? 'active' : '' }}">Messages</a>
      <div class="nav-avatar" title="{{ auth('client')->user()->nom }}">{{ strtoupper(substr(auth('client')->user()->nom,0,1)) }}</div>
      <form action="{{ route('client.logout') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="nav-btn nav-btn-outline"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
      </form>
    @else
      <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Accueil</a>
      <a href="{{ route('client.login') }}" class="nav-btn nav-btn-outline">Connexion</a>
      <a href="{{ route('client.register') }}" class="nav-btn nav-btn-primary"><i class="bi bi-person-plus"></i> Créer un compte</a>
    @endauth
  </div>
</nav>

@yield('content')

@stack('scripts')
</body>
</html>
