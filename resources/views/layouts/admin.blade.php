<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'GestiGarage') — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg-dark: #0d0f14;
      --bg-sidebar: #111318;
      --bg-card: #181c24;
      --bg-card-hover: #1e2330;
      --border: #252b3a;
      --accent: #f97316;
      --accent-soft: rgba(249,115,22,0.12);
      --accent2: #8b5cf6;
      --text-primary: #e8eaf0;
      --text-secondary: #8892a4;
      --text-muted: #4b5568;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --info: #3b82f6;
      --sidebar-w: 260px;
      --topbar-h: 64px;
      --radius: 12px;
      --shadow: 0 4px 24px rgba(0,0,0,0.4);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: var(--bg-dark); color: var(--text-primary); min-height: 100vh; display: flex; }

    /* ── Sidebar ── */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--bg-sidebar);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
      transition: transform 0.3s ease;
    }
    .sidebar-logo {
      padding: 24px 20px 20px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; gap: 12px;
    }
    .sidebar-logo .logo-icon {
      width: 40px; height: 40px;
      background: linear-gradient(135deg, var(--accent), #ea580c);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px;
    }
    .sidebar-logo .logo-text { font-weight: 800; font-size: 1.1rem; color: var(--text-primary); letter-spacing: -0.5px; }
    .sidebar-logo .logo-sub { font-size: 0.7rem; color: var(--text-secondary); margin-top: 1px; }

    .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
    .nav-label { font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; padding: 12px 8px 6px; }
    .nav-item {
      display: flex; align-items: center; gap: 12px;
      padding: 10px 12px; border-radius: 8px; margin-bottom: 2px;
      color: var(--text-secondary); font-size: 0.875rem; font-weight: 500;
      text-decoration: none; transition: all 0.2s;
      position: relative;
    }
    .nav-item i { font-size: 1.1rem; width: 20px; text-align: center; }
    .nav-item:hover { background: var(--bg-card); color: var(--text-primary); }
    .nav-item.active { background: var(--accent-soft); color: var(--accent); }
    .nav-item.active::before {
      content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
      width: 3px; height: 60%; background: var(--accent); border-radius: 0 2px 2px 0;
    }
    .nav-badge {
      margin-left: auto; background: var(--danger); color: white;
      font-size: 0.65rem; font-weight: 700; padding: 2px 6px; border-radius: 20px;
    }

    .sidebar-footer {
      padding: 16px 12px;
      border-top: 1px solid var(--border);
    }
    .sidebar-footer a {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 12px; border-radius: 8px; text-decoration: none;
      color: var(--text-secondary); font-size: 0.8rem; transition: all 0.2s;
    }
    .sidebar-footer a:hover { background: rgba(239,68,68,0.1); color: var(--danger); }

    /* ── Main ── */
    .main-wrap { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

    /* ── Topbar ── */
    .topbar {
      height: var(--topbar-h);
      background: var(--bg-sidebar);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 28px;
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-title { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
    .topbar-right { display: flex; align-items: center; gap: 16px; }
    .topbar-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 0.85rem; color: white;
    }

    /* ── Content ── */
    .page-content { padding: 28px; flex: 1; }

    /* ── Cards ── */
    .card {
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 20px;
    }
    .card-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 16px; padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }
    .card-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }

    /* ── Stat cards ── */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card {
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 20px;
      display: flex; align-items: flex-start; gap: 14px;
      transition: all 0.25s;
    }
    .stat-card:hover { border-color: var(--accent); transform: translateY(-2px); box-shadow: var(--shadow); }
    .stat-icon {
      width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
    }
    .stat-icon.orange { background: rgba(249,115,22,0.15); color: var(--accent); }
    .stat-icon.green  { background: rgba(16,185,129,0.15); color: var(--success); }
    .stat-icon.purple { background: rgba(139,92,246,0.15); color: var(--accent2); }
    .stat-icon.blue   { background: rgba(59,130,246,0.15); color: var(--info); }
    .stat-icon.red    { background: rgba(239,68,68,0.15);  color: var(--danger); }
    .stat-val { font-size: 1.6rem; font-weight: 800; line-height: 1; }
    .stat-label { font-size: 0.78rem; color: var(--text-secondary); margin-top: 4px; }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table.admin-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    .admin-table thead th {
      padding: 10px 14px; background: rgba(255,255,255,0.03);
      border-bottom: 1px solid var(--border);
      color: var(--text-secondary); font-weight: 600; font-size: 0.75rem;
      text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
    }
    .admin-table tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.15s; }
    .admin-table tbody tr:hover { background: rgba(255,255,255,0.03); }
    .admin-table tbody td { padding: 12px 14px; color: var(--text-primary); vertical-align: middle; }

    /* ── Badges ── */
    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600;
    }
    .badge-success { background: rgba(16,185,129,0.15); color: var(--success); }
    .badge-warning { background: rgba(245,158,11,0.15); color: var(--warning); }
    .badge-danger  { background: rgba(239,68,68,0.15);  color: var(--danger); }
    .badge-info    { background: rgba(59,130,246,0.15);  color: var(--info); }
    .badge-muted   { background: rgba(255,255,255,0.06); color: var(--text-secondary); }

    /* ── Buttons ── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; border: none; font-size: 0.825rem; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
    .btn-primary   { background: var(--accent); color: white; }
    .btn-primary:hover { background: #ea580c; color: white; }
    .btn-success   { background: var(--success); color: white; }
    .btn-success:hover { background: #059669; color: white; }
    .btn-danger    { background: rgba(239,68,68,0.15); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); }
    .btn-danger:hover { background: var(--danger); color: white; }
    .btn-secondary { background: rgba(255,255,255,0.08); color: var(--text-primary); border: 1px solid var(--border); }
    .btn-secondary:hover { background: rgba(255,255,255,0.12); color: var(--text-primary); }
    .btn-sm { padding: 5px 10px; font-size: 0.775rem; }
    .btn-icon { padding: 6px 8px; }

    /* ── Forms ── */
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control {
      width: 100%; padding: 10px 14px; border-radius: 8px;
      background: rgba(255,255,255,0.05); border: 1px solid var(--border);
      color: var(--text-primary); font-size: 0.875rem; transition: all 0.2s;
      font-family: 'Inter', sans-serif;
    }
    .form-control:focus { outline: none; border-color: var(--accent); background: rgba(249,115,22,0.06); }
    .form-control option { background: var(--bg-card); }
    textarea.form-control { resize: vertical; min-height: 100px; }

    /* ── Alerts ── */
    .alert { padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: var(--success); }
    .alert-danger  { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.3);  color: var(--danger); }
    .alert-info    { background: rgba(59,130,246,0.12); border: 1px solid rgba(59,130,246,0.3);  color: var(--info); }

    /* ── Page header ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 1.4rem; font-weight: 800; }
    .page-subtitle { font-size: 0.8rem; color: var(--text-secondary); margin-top: 2px; }

    /* ── Breadcrumb ── */
    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb span { color: var(--text-muted); }

    /* ── Detail row ── */
    .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; }
    .detail-item { }
    .detail-label { font-size: 0.72rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .detail-value { font-size: 0.9rem; color: var(--text-primary); font-weight: 500; }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .main-wrap { margin-left: 0; }
    }
  </style>
  @stack('styles')
</head>
<body>

<!-- ── Sidebar ── -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
    <div>
      <div class="logo-text">GestiGarage</div>
      <div class="logo-sub">Administration</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Principal</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
    </a>

    <div class="nav-label">Gestion</div>
    <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
      <i class="bi bi-people-fill"></i> Clients
    </a>
    <a href="{{ route('admin.vehicules.index') }}" class="nav-item {{ request()->routeIs('admin.vehicules.*') ? 'active' : '' }}">
      <i class="bi bi-car-front-fill"></i> Véhicules
    </a>
    <a href="{{ route('admin.reparations.index') }}" class="nav-item {{ request()->routeIs('admin.reparations.*') ? 'active' : '' }}">
      <i class="bi bi-tools"></i> Réparations
    </a>
    <a href="{{ route('admin.factures.index') }}" class="nav-item {{ request()->routeIs('admin.factures.*') ? 'active' : '' }}">
      <i class="bi bi-receipt"></i> Factures
    </a>

    <div class="nav-label">Communication</div>
    <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
      <i class="bi bi-chat-dots-fill"></i> Messages
      @php $unread = \App\Models\Message::where('statut','non_lu')->count(); @endphp
      @if($unread > 0) <span class="nav-badge">{{ $unread }}</span> @endif
    </a>

    <div class="nav-label">Portail</div>
    <a href="{{ route('welcome') }}" class="nav-item" target="_blank">
      <i class="bi bi-box-arrow-up-right"></i> Voir le site
    </a>
  </nav>

  <div class="sidebar-footer">
    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline; width:100%;">
      @csrf
      <button type="submit" style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; width:100%; background:transparent; border:none; text-align:left; color:var(--text-secondary); font-size:0.8rem; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.1)'; this.style.color='var(--danger)';" onmouseout="this.style.background='transparent'; this.style.color='var(--text-secondary)';">
        <i class="bi bi-power"></i> Déconnexion admin
      </button>
    </form>
  </div>
</aside>

<!-- ── Main ── -->
<div class="main-wrap">
  <header class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-right">
      <span style="font-size:0.8rem; color:var(--text-secondary);">{{ auth('web')->user()->name ?? 'Admin' }}</span>
      <div class="topbar-avatar">{{ auth('web')->user() ? strtoupper(substr(auth('web')->user()->name, 0, 1)) : 'A' }}</div>
    </div>
  </header>

  <main class="page-content">
    @if(session('success'))
      <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    @yield('content')
  </main>
</div>

@stack('scripts')
</body>
</html>
