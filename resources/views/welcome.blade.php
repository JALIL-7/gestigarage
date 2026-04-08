<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GestiGarage — Bienvenue</title>
  <meta name="description" content="GestiGarage — Gérez votre véhicule, suivez vos réparations en temps réel et contactez votre garage en ligne.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg: #080a0f;
      --bg2: #0d1117;
      --accent: #f97316;
      --accent2: #6366f1;
      --text: #f1f5f9;
      --muted: #64748b;
      --border: #1e2535;
      --card: #111520;
      --radius: 16px;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

    /* ── Noise overlay ── */
    body::before {
      content: '';
      position: fixed; inset: 0; z-index: -1;
      background: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
    }

    /* ── Navbar ── */
    nav {
      position: fixed; top: 0; left: 0; right: 0; z-index: 100;
      background: rgba(8,10,15,0.8); backdrop-filter: blur(24px);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 40px; height: 64px;
    }
    .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg,var(--accent),#ea580c); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 17px; }
    .logo-name { font-weight: 800; font-size: 1.05rem; color: var(--text); }
    .nav-links { display: flex; align-items: center; gap: 8px; }
    .nav-a { color: #94a3b8; font-size: 0.875rem; font-weight: 500; text-decoration: none; padding: 8px 12px; border-radius: 8px; transition: all 0.2s; }
    .nav-a:hover { color: var(--text); }
    .btn-nav { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 8px; font-size: 0.875rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: all 0.2s; }
    .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
    .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
    .btn-primary { background: var(--accent); color: white; }
    .btn-primary:hover { background: #ea580c; }

    /* ── Hero ── */
    .hero {
      min-height: 100vh;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      text-align: center; padding: 80px 24px 60px;
      position: relative; overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; top: -50%; left: 50%; transform: translateX(-50%);
      width: 800px; height: 800px; border-radius: 50%;
      background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, rgba(99,102,241,0.08) 40%, transparent 70%);
      pointer-events: none;
    }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.25);
      color: var(--accent); padding: 5px 14px; border-radius: 30px;
      font-size: 0.78rem; font-weight: 600; letter-spacing: 0.5px;
      margin-bottom: 28px; animation: fadeUp 0.6s ease;
    }
    .hero h1 {
      font-size: clamp(2.4rem, 6vw, 4.5rem);
      font-weight: 900; line-height: 1.1; letter-spacing: -2px;
      margin-bottom: 22px; animation: fadeUp 0.7s ease;
    }
    .hero h1 span { background: linear-gradient(135deg,var(--accent),#fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero p {
      max-width: 560px; font-size: 1.05rem; color: #94a3b8; line-height: 1.7;
      margin-bottom: 36px; animation: fadeUp 0.8s ease;
    }
    .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; animation: fadeUp 0.9s ease; }
    .hero-btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 10px; font-size: 0.95rem; font-weight: 700; text-decoration: none; border: none; cursor: pointer; transition: all 0.25s; }
    .hero-btn-primary { background: linear-gradient(135deg,var(--accent),#ea580c); color: white; box-shadow: 0 0 40px rgba(249,115,22,0.3); }
    .hero-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 60px rgba(249,115,22,0.4); }
    .hero-btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.15); color: var(--text); }
    .hero-btn-outline:hover { border-color: rgba(255,255,255,0.4); background: rgba(255,255,255,0.05); }

    /* ── Features ── */
    section { padding: 80px 40px; max-width: 1100px; margin: 0 auto; }
    .section-label { font-size: 0.75rem; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; }
    .section-title { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 14px; }
    .section-sub { color: #64748b; font-size: 1rem; max-width: 500px; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-top: 44px; }
    .feature-card {
      background: var(--card); border: 1px solid var(--border); border-radius: var(--radius);
      padding: 24px; transition: all 0.3s;
      position: relative; overflow: hidden;
    }
    .feature-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background: linear-gradient(90deg,var(--accent),var(--accent2)); opacity:0; transition:opacity 0.3s; }
    .feature-card:hover { transform: translateY(-4px); border-color: rgba(249,115,22,0.3); }
    .feature-card:hover::before { opacity: 1; }
    .feature-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 16px; }
    .fi-orange { background: rgba(249,115,22,0.15); color: var(--accent); }
    .fi-purple { background: rgba(99,102,241,0.15); color: var(--accent2); }
    .fi-green  { background: rgba(16,185,129,0.15); color: #10b981; }
    .fi-blue   { background: rgba(59,130,246,0.15); color: #3b82f6; }
    .feature-title { font-weight: 700; font-size: 0.95rem; margin-bottom: 8px; }
    .feature-text { font-size: 0.85rem; color: #64748b; line-height: 1.6; }

    /* ── CTA Section ── */
    .cta-section {
      margin: 0 40px 80px; padding: 60px;
      background: linear-gradient(135deg, rgba(249,115,22,0.12), rgba(99,102,241,0.08));
      border: 1px solid rgba(249,115,22,0.2);
      border-radius: 24px; text-align: center;
    }
    .cta-section h2 { font-size: 2rem; font-weight: 800; margin-bottom: 12px; }
    .cta-section p { color: #64748b; margin-bottom: 28px; font-size: 0.95rem; }

    /* ── Footer ── */
    footer { border-top: 1px solid var(--border); padding: 24px 40px; text-align: center; color: #334155; font-size: 0.8rem; }
    footer span { color: var(--accent); }

    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
  </style>
</head>
<body>

<nav>
  <a href="{{ route('welcome') }}" class="logo">
    <div class="logo-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
    <div class="logo-name">GestiGarage</div>
  </a>
  <div class="nav-links">
    <a href="#features" class="nav-a">Fonctionnalités</a>
    @auth('client')
      <a href="{{ route('client.dashboard') }}" class="btn-nav btn-outline">Mon espace</a>
    @else
      <a href="{{ route('client.login') }}" class="btn-nav btn-outline">Connexion</a>
      <a href="{{ route('client.register') }}" class="btn-nav btn-primary"><i class="bi bi-person-plus"></i> Inscription</a>
    @endauth
  </div>
</nav>

<!-- ── Hero ── -->
<section class="hero">
  <div class="hero-badge"><i class="bi bi-wrench-adjustable-circle-fill"></i> Service garage premium</div>
  <h1>Votre véhicule mérite<br>le <span>meilleur suivi</span></h1>
  <p>Suivez vos réparations en temps réel, consultez vos factures et communiquez directement avec notre équipe — depuis votre espace personnel.</p>
  <div class="hero-actions">
    @auth('client')
      <a href="{{ route('client.dashboard') }}" class="hero-btn hero-btn-primary"><i class="bi bi-grid-1x2-fill"></i> Mon tableau de bord</a>
    @else
      <a href="{{ route('client.register') }}" class="hero-btn hero-btn-primary"><i class="bi bi-person-plus-fill"></i> Créer mon espace</a>
      <a href="{{ route('client.login') }}" class="hero-btn hero-btn-outline"><i class="bi bi-box-arrow-in-right"></i> Me connecter</a>
    @endauth
  </div>
</section>

<!-- ── Features ── -->
<section id="features">
  <div class="section-label">Fonctionnalités</div>
  <h2 class="section-title">Tout pour votre tranquillité</h2>
  <p class="section-sub">Un espace client complet pour gérer chaque aspect de votre relation avec votre garage.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon fi-orange"><i class="bi bi-car-front-fill"></i></div>
      <div class="feature-title">Mes véhicules</div>
      <div class="feature-text">Consultez tous vos véhicules enregistrés, leur historique complet de réparations et leurs informations techniques.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon fi-purple"><i class="bi bi-tools"></i></div>
      <div class="feature-title">Suivi en temps réel</div>
      <div class="feature-text">Suivez le statut de chaque réparation : En attente, En cours ou Terminée — avec les dates et coûts associés.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon fi-green"><i class="bi bi-receipt-cutoff"></i></div>
      <div class="feature-title">Mes factures</div>
      <div class="feature-text">Accédez à toutes vos factures, vérifiez leur statut de paiement et téléchargez vos justificatifs.</div>
    </div>
    <div class="feature-card">
      <div class="feature-icon fi-blue"><i class="bi bi-chat-dots-fill"></i></div>
      <div class="feature-title">Messagerie directe</div>
      <div class="feature-text">Envoyez vos questions ou demandes directement à notre équipe et recevez leurs réponses dans votre espace.</div>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<div class="cta-section">
  <h2>Prêt à accéder à votre espace ?</h2>
  <p>Créez votre compte en quelques secondes ou connectez-vous si vous en avez déjà un.</p>
  <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
    @auth('client')
      <a href="{{ route('client.dashboard') }}" class="hero-btn hero-btn-primary"><i class="bi bi-grid-1x2-fill"></i> Accéder à mon espace</a>
    @else
      <a href="{{ route('client.register') }}" class="hero-btn hero-btn-primary"><i class="bi bi-person-plus-fill"></i> Créer mon compte</a>
      <a href="{{ route('client.login') }}" class="hero-btn hero-btn-outline"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
    @endauth
  </div>
</div>

<footer>
  <p>&copy; {{ date('Y') }} <span>GestiGarage</span> — Tous droits réservés</p>
</footer>

</body>
</html>